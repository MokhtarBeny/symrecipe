<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;

class IngredientTest extends PantherTestCase
{
    public function testIfCreateIngredientIsSuccessfull(): void
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', 'ingredient.new');
        

}
}