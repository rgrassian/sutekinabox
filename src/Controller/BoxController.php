<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 10/12/2018
 * Time: 17:31
 */

namespace App\Controller;


use App\Box\BoxType;
use App\Entity\Box;
use App\Entity\Produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BoxController extends Controller
{
    // @Security("has_role('ROLE_AUTEUR')")
    /**
     * formulaire pour créer une box
     * @Route("/nouvelle-box",
     *     name="new_box")
     */
    public function newBox(Request $request)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ACHAT');

        $box = new Box();

        $form = $this->createForm(BoxType::class, $box)
            ->handleRequest($request);

        // traitement des données POST
        // si le formulaire est soumis et valide
        if ( $form->isSubmitted() && $form->isValid() )
        {
            // sauvegarde en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($box);
            $em->flush();

            // notification
            $this->addFlash('notice',
                'La box est créée');

            // redirection vers l'article créé
            return $this->redirectToRoute('box_content', [
                'id' => $box->getId()
            ]);
        }
        //dump($form);

        $route = $this->get('request_stack')->getMasterRequest()->attributes->get('_route');

        // affichage du formulaire
        return $this->render('box/form.html.twig', [
            'form' => $form->createView(),
            'route' => $route,
            'box' => $box
        ]);
    }

    /**
     * formulaire pour éditer une box
     * @Route("/edit-box/{id<\d+>}",
     *     name="edit_box")
     */
    public function editBox(Box $box, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ACHAT');

        // Récupération du Formulaire
        $form = $this->createForm(BoxType::class, $box)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($box->getProduits() as $produit)
            {
                $box->addProduit($produit);
                //dd($box);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($box);
            $em->flush();
            //dd($box);

            $this->addFlash('notice',
                'La box a été mise à jour');

            return $this->redirectToRoute('index');
        }

        $catalogue = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findBy([],['nom' => 'ASC']);

        $route = $this->get('request_stack')->getMasterRequest()->attributes->get('_route');

        //dd($box->getProduits()[0]);
        return $this->render('box/form.html.twig', [
            'form' => $form->createView(),
            'route' => $route,
            'box' => $box,
            'produits' => $box->getProduits(),
            'catalogue' => $catalogue
        ]);
    }

    /**
     * API Json
     * @Route("/api/box/{id}/products",
     *     name="get_products_from_box")
     */
    public function getProduitsFromBox(Request $request, Box $box)
    {
        $products = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findByIdBoxOffsetLimitArray($box->getId(), 0, 10);

        return new JsonResponse($products);
    }

    /**
     * API Json
     * @Route("/api/catalogue/products",
     *     name="get_products_from_catalogue")
     */
    public function getProduitsFromCatalogue(Request $request)
    {
        $catalogue = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->findProduitsInCatalogue();

        return new JsonResponse($catalogue);
    }

    /**
     * API Json
     * @Route("/api/box/{id}/produit/remove",
     *     name="remove_product_from_box")
     */
    public function removeProduitFromBox(Request $request, $id)
    {
        $data = json_decode($request->getContent());

        $boxRepository = $this->getDoctrine()->getRepository(Box::class);
        $box = $boxRepository->findOneBy(['id' => $data->idBox]);

        $produitsRepository =  $this->getDoctrine()->getRepository(Produit::class);
        $produit = $produitsRepository->findOneBy(['id'=>$data->idProduit]);

        //dd($box);

        //remove from database

        $box->removeProduit($produit);
        $produit->setStatut('catalogue');

        $em = $this->getDoctrine()->getManager();
        $em->persist($box);
        $em->flush();

        return new JsonResponse([
            'isDeleted' => true
        ]);
    }

    /**
     * API Json
     * @Route("/api/box/{id}/produit/add",
     *     name="add_product_to_box")
     */
    public function addProduitToBox(Request $request, Box $box)
    {
        $produitId = json_decode($request->getContent(), true);

        //remove from database
        $produitsRepository =  $this->getDoctrine()->getRepository(Produit::class);
        $produit = $produitsRepository->findOneBy(['id'=>$produitId]);
        $boxRepository = $this->getDoctrine()->getRepository(Box::class);
        $box = $boxRepository->findOneBy(['id'=>$box->getId()]);
        $box->addProduit($produit);
        $produit->setStatut('en commande');

        $em = $this->getDoctrine()->getManager();
        $em->persist($box);
        $em->flush();

        return new JsonResponse([
            'isDeleted' => true
        ]);
    }

}