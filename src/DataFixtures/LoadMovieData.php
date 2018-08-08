<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 8/8/18
 * Time: 1:12 PM
 */

namespace App\DataFixtures;


use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovieData extends Fixture
{

    public function load(ObjectManager $manager)
    {
       $movie = new Movie();
       $movie->setTitle('Operation Y and Shurik\'s Other Adventures');
       $movie->setYear(1965);
       $movie->setTime(90);
       $movie->setDescription(
           ' is a 1965 Soviet slapstick comedy film directed by Leonid Gaidai,'.
           ' starring Aleksandr Demyanenko, Natalya Seleznyova, Yuri Nikulin, Georgy Vitsin and Yevgeny Morgunov.'
       );

       $manager->persist($movie);
       $manager->flush();
    }
}