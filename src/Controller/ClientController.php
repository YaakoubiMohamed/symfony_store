<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\Personne1Type;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'personnes' => $personneRepository->findByExampleField('client'),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(Personne1Type::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('client/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(Personne1Type::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }
}
