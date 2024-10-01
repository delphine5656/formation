<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SigningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class SigningController extends AbstractController
{
    #[Route('/signing', name: 'app_signing')]
    public function index(Request $req, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        //creation du form
        $form = $this->createForm(SigningType::class, $user);

        //traitement du form

        $form->handleRequest($req); //form soumis

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            //hasher me mot de passe
            //ON RECUPERE LE MOT DE PASSE
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
        }


        return $this->render('signing/index.html.twig', [
            'form' => $form ->createView(), //on crée la vue
        ]);
    }


}
