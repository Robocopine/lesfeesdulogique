<?php

namespace App\Controller;

use App\Entity\Substance;
use App\Form\SubstanceType;
use App\Repository\SubstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RecipesController extends AbstractController
{

    # SUBSTANCE

    #[Route('/substance', name: 'app_substance_index', methods: ['GET'])]
    public function index(SubstanceRepository $substanceRepository): Response
    {
        return $this->render('recipes/substance/index.html.twig', [
            'substances' => $substanceRepository->findAll(),
        ]);
    }

    #[Route('/substance/nouveau', name: 'app_substance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubstanceRepository $substanceRepository): Response
    {
        $substance = new Substance();
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $substanceRepository->save($substance, true);

            return $this->redirectToRoute('app_substance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipes/substance/new.html.twig', [
            'substance' => $substance,
            'form' => $form,
        ]);
    }

    #[Route('/substance/{id}', name: 'app_substance_show', methods: ['GET'])]
    public function show(Substance $substance): Response
    {
        return $this->render('recipes/substance/show.html.twig', [
            'substance' => $substance,
        ]);
    }

    #[Route('/substance/{id}/modifier', name: 'app_substance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Substance $substance, SubstanceRepository $substanceRepository): Response
    {
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $substanceRepository->save($substance, true);

            return $this->redirectToRoute('app_substance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipes/substance/edit.html.twig', [
            'substance' => $substance,
            'form' => $form,
        ]);
    }

    #[Route('/substance/{id}', name: 'app_substance_delete', methods: ['POST'])]
    public function delete(Request $request, Substance $substance, SubstanceRepository $substanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$substance->getId(), $request->request->get('_token'))) {
            $substanceRepository->remove($substance, true);
        }

        return $this->redirectToRoute('app_substance_index', [], Response::HTTP_SEE_OTHER);
    }
}
