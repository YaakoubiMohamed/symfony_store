<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\PromotionRepository;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository,PromotionRepository $promotionRepository): Response
    {
        return $this->render('index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'promotions' => $promotionRepository->findAll(),
        ]);
    }
}
