<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 28/01/2019
 * Time: 09:44
 */

namespace App\DataFixtures;


use App\Entity\Box;
use Doctrine\Common\Persistence\ObjectManager;

class BoxFixtures
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i ++){
            $room = new Box();

            $room->setName();
            $room->setCapacity(10);
            $room->setFeatures(['Wifi','Chauffage au sol']);
            $room->setPicture($faker->imageUrl());

            $manager->persist($room);
        }

        $manager->flush();
    }
}