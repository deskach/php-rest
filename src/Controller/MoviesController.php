<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 8/8/18
 * Time: 3:35 PM
 */

namespace App\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\FOSRestController;

class MoviesController extends FOSRestController
{
//    use ControllerTrait;

    /**
     * @Rest\Route("/api/movies", name="api_movies")
     * @Rest\View()
     */
    public function getMoviesAction() {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();
        $view = $this->view($movies, 200);

        return $this->handleView($view);
    }
}