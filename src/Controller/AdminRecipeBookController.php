<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Entity\Substance;
use App\Form\SubstanceType;
use App\Service\PaginationService;
use App\Repository\RecipeRepository;
use App\Repository\SubstanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_recipe_book_')]
class AdminRecipeBookController extends AbstractController
{
    # RECIPE

    #[Route('/recettes/{page<\d+>?1}', name: 'recipe_index', methods: ['GET'])]
    public function indexRecipe(PaginationService $pagination, $page): Response
    {
        $pagination->setEntityClass(Recipe::class)
            ->setPage($page);
        return $this->render('admin/recipe-book/recipe/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    
    #[Route('/recette/nouveau', name: 'recipe_new', methods: ['GET', 'POST'])]
    public function newRecipe(Request $request,ManagerRegistry $doctrine, RecipeRepository $recipeRepository): Response
    {
        $entityManager = $doctrine->getManager();
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($recipe->getIngredient() as $ingredient) {
                $ingredient->setRecipe($recipe);
                $entityManager->persist($ingredient);  
            }
            $entityManager->flush();
            $recipeRepository->save($recipe, true);

            return $this->redirectToRoute('admin_recipe_book_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recipe-book/recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/recette/modifier/{id}', name: 'recipe_edit', methods: ['GET', 'POST'])]
    public function editRecipe(Request $request, Recipe $recipe, RecipeRepository $recipeRepository,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach($recipe->getIngredient() as $ingredient) {
                
                
                $ingredient->setRecipe($recipe);
                $entityManager->persist($ingredient);  
                if($ingredient->getSubstance() == NULL){
                    $recipe->removeIngredient($ingredient);
                }
                
            }
            $entityManager->flush();
            $recipeRepository->save($recipe, true);

            return $this->redirectToRoute('admin_recipe_book_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recipe-book/recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/recette/{id}', name: 'recipe_show', methods: ['GET'])]
    public function showRecipe(Recipe $recipe): Response
    {
        return $this->render('admin/recipe-book/recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recette/{id}', name: 'recipe_delete', methods: ['POST'])]
    public function deleteRecipe(Request $request, Recipe $recipe, RecipeRepository $recipeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $recipeRepository->remove($recipe, true);
        }

        return $this->redirectToRoute('admin_recipe_book_recipe_index', [], Response::HTTP_SEE_OTHER);
    }

    # INGREDIENT
    
    #[Route('/ingredient/{id}/{route}', name: 'ingredient_delete', methods: ['POST'])]
    public function deleteIngredient(Request $request, Ingredient $ingredient, IngredientRepository $ingredientRepository, $route): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $ingredientRepository->remove($ingredient, true);
        }

        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }

    # SUBSTANCE

    #[Route('/composants/{page<\d+>?1}', name: 'substance_index', methods: ['GET'])]
    public function indexSubstance(PaginationService $pagination, $page): Response
    {
        $pagination->setEntityClass(Substance::class)
                   ->setPage($page);
        return $this->render('admin/recipe-book/substance/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/composant/nouveau', name: 'substance_new', methods: ['GET', 'POST'])]
    public function newSubstance(Request $request, SubstanceRepository $substanceRepository): Response
    {
        $substance = new Substance();
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $substanceRepository->save($substance, true);

            return $this->redirectToRoute('admin_recipe_book_substance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recipe-book/substance/new.html.twig', [
            'substance' => $substance,
            'form' => $form,
        ]);
    }



    #[Route('/composant/modifier/{id}', name: 'substance_edit', methods: ['GET', 'POST'])]
    public function editSubstance(Request $request, Substance $substance, SubstanceRepository $substanceRepository): Response
    {
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $substanceRepository->save($substance, true);

            return $this->redirectToRoute('admin_recipe_book_substance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recipe-book/substance/edit.html.twig', [
            'substance' => $substance,
            'form' => $form,
        ]);
    }

    #[Route('/composant/{id}/{lg}', name: 'substance_show', methods: ['GET'])]
    public function showSubstance(Substance $substance, string $lg = 'fr'): Response
    {
        return $this->render('admin/recipe-book/substance/show.html.twig', [
            'substance' => $substance,
            'lg' => $lg
        ]);
    }


    #[Route('/composant/{id}', name: 'substance_delete', methods: ['POST'])]
    public function deleteSubstance(Request $request, Substance $substance, SubstanceRepository $substanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$substance->getId(), $request->request->get('_token'))) {
            $substanceRepository->remove($substance, true);
        }

        return $this->redirectToRoute('admin_recipe_book_substance_index', [], Response::HTTP_SEE_OTHER);
    }


}
