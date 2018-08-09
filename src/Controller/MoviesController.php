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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MoviesController extends FOSRestController
{
//    use ControllerTrait;

    /**
     * @Rest\Route("/api/movies", name="movies_get", methods={"GET"})
     * @Rest\View()
     */
    public function getMoviesAction() {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();
        $view = $this->view($movies, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Route("/api/movies", name="movies_post", methods={"POST"})
     * @Rest\View(statusCode=201)
     * @ParamConverter("movie", converter="fos_rest.request_body")
     * @param Movie $movie
     */
    public function postMoviesAction(Movie $movie) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();
    }
}