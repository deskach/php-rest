<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 8/8/18
 * Time: 3:35 PM
 */

namespace App\Controller;


use App\Entity\Movie;
use App\Exception\ValidationException;
use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MoviesController extends FOSRestController
{
//    use ControllerTrait;

    /**
     * @ORM\Column(type="string")
     */
    private $validator;

    public function __construct(ValidatorInterface $aValidator)
    {
        $this->validator = $aValidator;
    }

    /**
     * @Rest\Route("/api/movies", name="movies_get", methods={"GET"})
     * @Rest\View()
     */
    public function getMoviesAction() {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();

        return $this->handleView($this->view($movies, 200));
    }

    /**
     * @Rest\Route("/api/movies/{movieId}", name="movies_find", methods={"GET"})
     * @param string $movieId
     * @return Response
     * @Rest\View()
     */
    public function getMovieAction(string $movieId) {
        $movie = $this->getDoctrine()->getRepository('App:Movie')->find($movieId);

        if(null === $movie) {
            return $this->handleView($this->view(null, 404));
        }

        return $this->handleView($this->view($movie, 200));
    }

    /**
     * @Rest\Route("/api/movies", name="movies_post", methods={"POST"})
     * @Rest\View(statusCode=201)
     * @ParamConverter("movie", converter="fos_rest.request_body")
     * @param Movie $movie
     * @return Movie | Response
     * @throws HttpException
     */
    public function postMoviesAction(Movie $movie) {
        $this->validate($movie);

        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();

        return $movie;
    }

    /**
     * @Rest\Route("/api/movies/{movieId}", name="movies_delete", methods={"DELETE"})
     * @Rest\View()
     * @param string $movieId
     * @return Response
     */
    public function deleteMovieAction(string $movieId) {
        $movie = $this->getDoctrine()->getRepository('App:Movie')->find($movieId);

        if(null === $movie) {
            return $this->handleView($this->view(null, 404));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();

        return $this->handleView($this->view(null, 202));
    }

    /**
     * @param Movie $movie
     */
    private function validate(Movie $movie) {
        $errors = $this->validator->validate($movie);

        if (count($errors) > 0) {
//            $error1 = $errors->get(0);
//            $message = $error1->getPropertyPath()." ".$error1->getMessage();
//
//            throw new HttpException(400, $message);
            throw new ValidationException($errors);
        }
    }
}