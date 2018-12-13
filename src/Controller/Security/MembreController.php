<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 11/12/2018
 * Time: 13:23
 */

namespace App\Controller\Security;


use App\Entity\Membre;
use App\Membre\MembreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreController extends Controller
{
    /**
     * @Route("admin/inscription",
     *     methods={"GET", "POST"},
     *     name="membre_inscription")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $membre = new Membre();

        $form = $this->createForm(MembreType::class, $membre)
            ->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() )
        {
            $membre->setPassword($passwordEncoder->encodePassword($membre, $membre->getPassword()));

            // sauvegarde en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            // notification
            $this->addFlash('notice',
                'Nouveau membre inscrit');

            // redirection vers l'accueil
            return $this->redirectToRoute('security_connexion');

        }


        return $this->render('membre/inscription.html.twig', ['form' => $form->createView()]);

    }


}