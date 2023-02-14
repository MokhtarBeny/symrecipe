<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactTest extends WebTestCase
{
    public function testIfSubmitContactFormIsSuccessfull(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Formulaire de contact');  // Vérifier le titre de la page 
        
        // Récupérer le formulaire
        
        $submitButton = $crawler->selectButton('Soumettre ma demande');
        $form = $submitButton->form();
        
        $form["contact[fullName]"] = "test test";
        $form["contact[email]"] = "jd@symrecipe.com";
        $form["contact[subject]"] = "Test";
        $form["contact[message]"] = "Test";
        
        //Soumetttre le formulaire
        
        
        $client->submit($form);
        
        
        // Vérifier le statut HTTP
        
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
        // Vérifier l'envoi du mail 
        
        $this->assertEmailCount(1);
        
        $client->followRedirect();
        
        // Vérifier la présence du message de succès
        
        $this->assertSelectorTextContains(
            'div.alert.alert-success.mt-4',
            'Votre demande a été envoyé avec succès !'

        );
    }
}
