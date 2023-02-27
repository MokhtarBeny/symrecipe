<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IngredientTest extends WebTestCase

{
    public function testIfCreateIngredientIsSuccessfull(): void
    {
        $client = static::createClient();
        
        //Recup urlgenerator
        
        $urlGenerator = $client->getContainer()->get('router');
        
        // Recupérer entity manager
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $user = $entityManager->find(User::class, 1);
        
        $client->loginUser($user);
        
        // Se rendre sur la page de création d'un ingrédient
        
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('ingredient.new'));
        
        // Gérer le formulaire
        
        $form = $crawler->filter('form[name=ingredient]')->form([
            'ingredient[name]' => "Un ingrédient test 1",
            'ingredient[price]' => floatval(36)
        ]);
        
        $client->submit($form);
        
        
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
        // Gérer la redirection

        $client->followRedirect();

        // Gérer l'alert box et la route
        
        $this->assertSelectorTextContains('div.alert-success', 'Votre ingrédient a été créé avec succès !');

        $this->assertRouteSame('ingredient.index');
        
    }

    public function  testIsListingIngredientIsSuccessfull(): void

    {
        $client = static::createClient();
        
         $urlGenerator = $client->getContainer()->get('router');
         
         $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
         
         $user = $entityManager->find(User::class, 1);
         
         $client->loginUser($user);

         $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('ingredient.new'));

    }

    public function testIfUpdateIngredientIsSuccessfull() : void 

    {
        $client = static::createClient();

        

        // $client->followRedirects();

        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class,1);
        $ingredient = $entityManager->getRepository(Ingredient::class)->findOneBy([

            'user' => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('ingredient.edit', ['id' =>$ingredient->getId()])

        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=ingredient]')->form([

            'ingredient[name]' => "Un ingrédient test 2",
            'ingredient[price]' => floatval(39)
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();       

        $this->assertSelectorTextContains('div.alert-success', 'Votre ingrédient a été modifié avec succès');

        $this->assertRouteSame('ingredient.index');

   
    }

    public function testIfDeleteIngredientIsSuccessful() : void

    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class,1);
        $ingredient = $entityManager->getRepository(Ingredient::class)->findOneBy([

            'user' => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('ingredient.delete', ['id' =>$ingredient->getId()])

        );

        
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();       

        $this->assertSelectorTextContains('div.alert-success', 'Votre ingrédient a été supprimé avec succès');

        $this->assertRouteSame('ingredient.index');


    }
}
