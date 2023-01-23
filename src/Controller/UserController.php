<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{   
    /**
     * This Controller allow us to edit user's profile
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher ): Response
    {
        
        if(!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }
        
        if($this->getUser() !== $user) {
            return $this->redirectToRoute('recipe.index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) 
            {

            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées'
            );

            return $this->redirectToRoute('recipe.index');
            }
             else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );

            }       
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST' ])]

    /**
     * This controller allow us to edit user password
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function editPassword(
        User $user,
         Request $request,
          EntityManagerInterface $manager,
          UserPasswordHasherInterface $hasher
          ) : Response
    
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('recipe.index');
        }
        
        
        
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setupdatedAt(new \DateTimeImmutable());
                $user->setPlainPassword(
                    
                    $form->getData()['newPassword']   
                );

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié '
                );

                $manager->persist($user);
                $manager->flush();

                

                return $this->redirectToRoute('recipe.index');
            } 
            else{
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }
         }

        return $this->render('pages/user/edit_password.html.twig', [

            'form' => $form->createView()
        ]);

    }
}
