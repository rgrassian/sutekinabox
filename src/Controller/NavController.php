<?php

namespace App\Controller;

use App\Entity\Box;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavController extends AbstractController
{

    public function topnav()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $route = $this->get('request_stack')->getMasterRequest()->attributes->get('_route');

        $repository = $this->getDoctrine()->getRepository(Box::class);
        $boxToEdit = null;
        if (isset($repository->findBoxToBeEdited()[0]))
        {
            $boxToEdit = $repository->findBoxToBeEdited()[0];
        }

        return $this->render('component/_nav.html.twig', [
            'user' => $user,
            'route' => $route,
            'boxToEdit' => $boxToEdit
        ]);
    }

}