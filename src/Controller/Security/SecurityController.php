<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 11/12/2018
 * Time: 10:30
 */

namespace App\Controller\Security;


use App\Entity\Membre;
use App\Membre\MembreLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * connexion d'un membre
     * @Route("/connexion", name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        /**
         * si l'utilisateur est déjà connecté il est redirigé sur l'accueil
         */
        if($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        //$repository = $this->getDoctrine()->getRepository(Membre::class);
        //$user = $repository->findOneBy(['id'=>1]);
        //$user->setPassword('sutekina');

        //$em = $this->getDoctrine()->getManager();
        //$em->persist($user);
        //$em->flush();

        // récupération du formulaire de connexion
        $form = $this->createForm(MembreLoginType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/connexion.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * déconnexion d'un membre
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function deconnexion()
    {

    }

}