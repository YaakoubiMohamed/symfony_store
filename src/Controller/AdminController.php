<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\PromotionRepository;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository,PromotionRepository $promotionRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'produits' => $produitRepository->findAll(),
            'promotions' => $promotionRepository->findAll(),
        ]);
    }
}
