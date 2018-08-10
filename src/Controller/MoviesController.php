<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 8/8/18
 * Time: 3:35 PM
 */

namespace App\Controller;


use App\Entity\Movie;
use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class MoviesController extends FOSRestController
{
//    use ControllerTrait;

    /**
     * @Rest\Route("/api/movies", name="movies_get", methods={"GET"})
     * @Rest\View()
     */
    public function getMoviesAction() {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();

        return $this->handleView($this->view($movies, 200));
    }

    /**
     * @Rest\Route("/api/movies", name="movies_post", methods={"POST"})
     * @Rest\View(statusCode=201)
     * @ParamConverter("movie", converter="fos_rest.request_body")
     * @param Movie $movie
     * @return Movie
     */
    public function postMoviesAction(Movie $movie) {
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
}