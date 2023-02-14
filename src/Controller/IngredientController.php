<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{

/**
 * This controller display all ingredients.
 *
 * @param IngredientRepository $repository
 * @param PaginatorInterface $paginator
 * @param Request $request
 * @return Response
 */
    #[Route('/ingredient', name: 'ingredient.index')]
    #[IsGranted('ROLE_USER')]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1), 
            10
        );

         return $this->render('ingredient/index.html.twig', [

            'ingredients' => $ingredients

        ]);
    }
    /**
     * This controller show a form which an ingredient.
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/nouveau', 'ingredient.new') ]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);        
        if($form->isSubmitted() && $form->isValid()) {
           
            $ingredient = $form->getData();

            $ingredient->setUser($this->getUser());

           

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été créé avec succès !'

            );

            return $this->redirectToRoute('ingredient.index');
                  
           
        }
        
        return $this->render('ingredient/new.html.twig',[
            'form' => $form->createView()
        ]);

    }

    #[Security("is_granted('ROLE_USER') and user === ingredient.getUser()")]
    #[Route('/ingredient/edition/{id}', 'ingredient.edit', methods: ['GET', 'POST'])]
  
    public function edit(
        Ingredient $ingredient, 
        Request $request, 
        EntityManagerInterface $manager
        ): Response {

        
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);        
        if($form->isSubmitted() && $form->isValid()) {
           
            $ingredient = $form->getData();

           

            $manager->persist($ingredient);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès'
                
            );
            
            
            return $this->redirectToRoute('ingredient.index');
            
        }

        return $this->render('ingredient/edit.html.twig',[

            'form' => $form->createView()
        ]);
    }

    #[Route('/ingredient/supression/{id}', 'ingredient.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Ingredient $ingredient) : Response {        
        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès'

        );

        return $this->redirectToRoute('ingredient.index');
    }
 }