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
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('panier.html.twig');
    }
}
