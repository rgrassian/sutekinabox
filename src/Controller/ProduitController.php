<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 12/12/2018
 * Time: 18:49
 */

namespace App\Controller;


use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends Controller
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

}