<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("produitfront/")
 */
class ProduitFrontController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit,CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        $categories = $categorieRepository->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get('nom');
            $prix = $request->get('prix');
            $couleur = $request->get('couleur');
            $quantite = $request->get('quantite');
            $marque = $request->get('marque');
            $image = $request->file('image');
            dd($image);
            $description = $request->get('description');
            $id_categorie= $request->get('categorie');
            $categorie = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->find($id_categorie);
            //dd($categorie);
            $produit->setNom($nom);
            $produit->setPrix($prix);
            $produit->setCouleur($couleur);
            $produit->setQuantite($quantite);
            $produit->setMarque($marque);
            //$produit->setImage($image);
            $produit->setDescription($description);
            $produit->setCategorie($categorie);
            dd($produit);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }
}
