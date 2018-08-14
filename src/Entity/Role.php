<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 14/8/18
 * Time: 8:12 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $person;

    /**
     * @ORM\Column(type="string", name="played_name", length=100)
     */
    private $playedName;

    /**
     * @ORM\Column(type="string")
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="roles")
     */
    private $movie;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person): void
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getPlayedName()
    {
        return $this->playedName;
    }

    /**
     * @param mixed $playedName
     */
    public function setPlayedName($playedName): void
    {
        $this->playedName = $playedName;
    }

    /**
     * @return mixed
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @param mixed $movie
     */
    public function setMovie($movie): void
    {
        $this->movie = $movie;
    }
}