<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/12/2018
 * Time: 11:10
 */

namespace App\Controller;


use App\Entity\Box;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()
            ->getRepository(Box::class);

        $archivedBoxList = $repository->findArchivedBox();

        $boxToEdit = null;
        if (isset($repository->findBoxToBeEdited()[0]))
        {
            $boxToEdit = $repository->findBoxToBeEdited()[0];
        }

        $produitsRepository =  $this->getDoctrine()->getRepository(Produit::class);
        $produit = $produitsRepository->findOneBy(['id'=>7]);
        $boxRepository = $this->getDoctrine()->getRepository(Box::class);
        $box = $boxRepository->findOneBy(['id'=>2]);
        $box->addProduit($produit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($box);
        $em->flush();


        return $this->render('front/admin.html.twig', [
            'boxList' => $archivedBoxList,
            'boxToEdit' => $boxToEdit
        ]);
    }

    /**
     * affiche le contenu d'une box
     * @Route("/box/{id<\d+>}",
     *     name="box_content")
     */
    public function box($id, Box $box = null)
    {
        //dd($box);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('front/box.html.twig', [
            'box' => $box,
            'produits' => $box->getProduits()
        ]);
    }

    /**
     * affiche la liste des produits
     * @Route("/produits",
     *     name="products_list")
     */
    public function products()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()
            ->getRepository(Produit::class);

        $produits = $repository->findBy([],['nom' => 'ASC']);

        return $this->render('front/produits.html.twig', [
            'produits' => $produits]);
    }

    /**
     * affiche les détails d'un produit
     * @Route("/produit/{id<\d+>}",
     *     name="product_details")
     */
    public function product($id, Produit $produit = null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (null === $produit)
        {
            return $this->redirectToRoute('index', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        $repository = $this->getDoctrine()
            ->getRepository(Produit::class);

        $produit = $repository->findOneBy(['id' => $id]);
        //dd($produit->getBox());
        //dd($produit);

        return $this->render('front/produit.html.twig', [
            'produit' => $produit,
            'fournisseur' => $produit->getFournisseur()
        ]);
    }

    /**
     * affiche la liste des fournisseurs
     * @Route("/fournisseurs",
     *     name="fournisseurs_list")
     */
    public function fournisseurs()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()
            ->getRepository(Fournisseur::class);

        $fournisseurs = $repository->findBy([],['nom' => 'ASC']);

        return $this->render('front/fournisseurs.html.twig', [
            'fournisseurs' => $fournisseurs]);
    }

    /**
     * affiche les détails d'un fournisseur
     * @Route("/fournisseur/{id<\d+>}",
     *     name="fournisseur_details")
     */
    public function fournisseur($id, Fournisseur $fournisseur = null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (null === $fournisseur)
        {
            return $this->redirectToRoute('index', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        $repository = $this->getDoctrine()
            ->getRepository(Fournisseur::class);

        $fournisseur = $repository->findOneBy(['id' => $id]);

        return $this->render('front/fournisseur.html.twig', [
            'fournisseur' => $fournisseur,
            'produits' => $fournisseur->getProduits()
        ]);
    }

}