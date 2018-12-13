<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * formulaire pour créer une box
     * @Route("/commandes",
     *     name="commandes")
     */
    public function Commandes()
    {
        $this->denyAccessUnlessGranted('ROLE_LOGISTIQUE');

        $repository = $this->getDoctrine()
            ->getRepository(Produit::class);

        $produitsEnCommande = $repository->findByStatut('en commande');
        $produitsEnStock = $repository->findByStatut('en stock');

        return $this->render('front/commandes.html.twig', [
            'produits_en_commande' => $produitsEnCommande,
            'produits_en_stock' => $produitsEnStock
        ]);
    }

    /**
     * formulaire pour valider les livraisons
     * @Route("/qualite",
     *     name="qualite")
     */

    public function Qualite()
    {
        $this->denyAccessUnlessGranted('ROLE_QUALITE');

        $repository = $this->getDoctrine()
            ->getRepository(Produit::class);

        $produitsEnStock = $repository->findByStatut('en stock');
        $produitsConformes = $repository->findByStatut('conforme');
        $produitsNonConformes = $repository->findByStatut('non conforme');

        return $this->render('front/qualite.html.twig', [
            'produits_en_stock' => $produitsEnStock,
            'produits_conformes' => $produitsConformes,
            'produits_non_conformes' => $produitsNonConformes,
        ]);
    }

    /**
     * @Route("/", name="produit_index", methods="GET")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', ['produits' => $produitRepository->findAll()]);
    }

    /**
     * @Route("/new", name="produit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("produit/{id}", name="produit_show", methods="GET")
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', ['produit' => $produit]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods="GET|POST")
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index', ['id' => $produit->getId()]);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods="DELETE")
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }
}
