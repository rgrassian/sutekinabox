<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavController extends AbstractController
{

    public function topnav()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $route = $this->get('request_stack')->getMasterRequest()->attributes->get('_route');

        return $this->render('component/_nav.html.twig', [
            'user' => $user,
            'route' => $route
        ]);
    }

}