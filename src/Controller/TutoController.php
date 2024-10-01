<?php

namespace App\Controller;

use App\Entity\Tuto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    //recup données depuis notre base de donnée
    #[Route('/tuto:{id}', name: 'app_tuto')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {
        $tuto = $entityManager->getRepository(Tuto::class)->find($id);

        // message erreur si aucun produit n'a ete trouve
        if(!$tuto){
            throw $this->createNotFoundException(
                'Aucun produit n\' a été trouvé'.$id
            );
        }


        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $tuto ->getName()  //affiche le produit recuperé
        ]);
    }

//creer données pour la table tuto
    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $tuto = new Tuto();
        $tuto->setName('Image-AI');
        $tuto->setSlug('image-ai');
        $tuto->setSubtitle('Apprendre à créer une image avec l\'AI');
        $tuto->setDescription('créer une superbe image avec intelligence artificielle');
        $tuto->setImage('ai.png');
        $tuto->setVideo('B6qb-1IoQw');
        $tuto->setLink('https://www.formation-facile.fr/formations/formation-unity-et-c-developpeur-de-jeux-video');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($tuto);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$tuto->getId());
    }


}
