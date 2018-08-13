<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 13/8/18
 * Time: 12:49 PM
 */

namespace App\Controller;


use App\Entity\Person;
use App\Exception\ValidationException;
use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends FOSRestController
{
    /**
     * @ORM\Column(type="string")
     */
    private $validator;

    /**
     * PersonController constructor.
     * @param ValidatorInterface $aValidator
     */
    public function __construct(ValidatorInterface $aValidator)
    {
        $this->validator = $aValidator;
    }

    /**
     * @Rest\Route("/api/people", name="people_get", methods={"GET"})
     * @Rest\View()
     */
    public function getPeopleAction() {
        $movies = $this->getDoctrine()->getRepository('App:Person')->findAll();

        return $this->handleView($this->view($movies, 200));
    }

    /**
     * @param Person $person
     * @Rest\View(statusCode=201)
     * @ParamConverter("person", converter="fos_rest.request_body")
     * @Rest\Route("/api/people", name="people_post", methods={"POST"})
     * @return Person
     */
    public function postPeopleAction(Person $person) {
        $this->validate($person);

        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();

        return $person;
    }

    /**
     * @Rest\Route("/api/people/{personId}", name="people_find", methods={"GET"})
     * @param string $personId
     * @return Response
     * @Rest\View()
     */
    public function getPersonAction(string $personId) {
        $person = $this->getDoctrine()->getRepository('App:Person')->find($personId);

        if(null === $person) {
            return $this->handleView($this->view(null, 404));
        }

        return $this->handleView($this->view($person, 200));
    }

    /**
     * @Rest\Route("/api/people/{personId}", name="people_delete", methods={"DELETE"})
     * @Rest\View()
     * @param string $personId
     * @return Response
     */
    public function deleteMovieAction(string $personId) {
        $person = $this->getDoctrine()->getRepository('App:Person')->find($personId);

        if(null === $person) {
            return $this->handleView($this->view(null, 404));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        return $this->handleView($this->view(null, 202));
    }

    private function validate(Person $person) {
        $errors = $this->validator->validate($person);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

}