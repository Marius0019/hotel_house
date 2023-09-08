<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Commande;
use App\Form\ChambreType;
use App\Form\CommandeType;
use App\Repository\SliderRepository;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController

// Page d'accueil
{
    #[Route('/', name: 'home')]
    public function home( SliderRepository $repo): Response
    {
        // $produit = $repo->findAll();
        $slider = $repo->findBy([], ['ordre' => 'ASC']);
        return $this->render('app/index.html.twig', [ 
            'sliders' => $slider
            // 'produits' => $produit,
        ]);
    }

// Page Contact
    #[Route('app/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('app/contact.html.twig', [
        ]);
    }

// Page Chambres
    #[Route('app/chambres', name: 'app_chambres')]
    public function chambres(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('app/chambres/chambres.html.twig', [
            'chambres' =>$chambres,
        ]);
    }

// Page Chambre Classique

    #[Route('app/chambres/{id}', name: 'app_chambre_show')]
    public function chambresClassique(Chambre $chambre, ChambreRepository $repo, EntityManagerInterface $manager, Request $rq, SessionInterface $session): Response
    {

         $commandes = new Commande;
            $form = $this->createForm(CommandeType::class, $commandes);
            $form->handleRequest($rq);

        if ($form->isSubmitted() && $form->isValid()) {
            // $commandes->setUser($this->getUser());
            $commandes->setDateEnregistrement(new \DateTime());
            // $chambre->setChambre($chambre);

            $depart = $commandes->getDateArrivee();
            //*on vérifie si la différence est négative et donc que DateHeureFin est un date antérieur a DateHeureDepart
            if ($depart->diff($commandes->getDateDepart())->invert == 1) {
                //* si les dates sont incorrectes, recharge la page et affiche une erreur
                $this->addFlash('danger', 'Une période de temps ne peut pas être négative.');
                return $this->redirectToRoute('app_chambre_resa', [
                    'id' => $commandes->getId()
                ]);
            }
            //* on récupère la différence de jour entre les dates
            $jours = $depart->diff($commandes->getDateDepart())->days;
            //* récupère le prix total (sans la dernière addition, il manque un jour à payer)
            $prixTotal = ($commandes->getChambre()->getPrixJournalier() * $jours) + $commandes->getChambre()->getPrixJournalier();
            

            $commandes->setPrixTotal($prixTotal);

            $manager->persist($commandes);
            $manager->flush();
            $this->addFlash('success', 'Votre commande a bien été enregistrée !');
            return $this->redirectToRoute('home');
        }

        return $this->render('app/chambres/chambre_show.html.twig', [
            'form' => $form,
            'chambre' => $chambre
        ]);
       
    }

// Page Chambre Confort

    #[Route('app/chambres/confort', name: 'app_chambre_confort')]
    public function chambresConfort(): Response
    {
        return $this->render('app/chambres/chambre_confort.html.twig', [
        ]);
    }

// Page Chambre Suite

    #[Route('app/chambres/suite', name: 'app_chambre_suite')]
    public function chambresSuite(): Response
    {
        return $this->render('app/chambres/chambre_suite.html.twig', [
        ]);
    }

// Page Chambre Réservation

    // #[Route('app/chambres/resa/{id}', name: 'app_chambre_resa')]
    //     public function chambresResa(Chambre $chambre, ChambreRepository $repo, EntityManagerInterface $manager, Request $rq, SessionInterface $session): Response
    //     {

            // if (!$chambre)
            //     return $this->redirectToRoute('home');
    
            //  $session->set('url_precedente', $rq->getRequestUri());
             
            // $commande = new Commande;
            // $form = $this->createForm(CommandeType::class, $commande);
            // $form->handleRequest($rq);
    
           
        
    

    #[Route('app/actualite', name: 'app_actualite')]
    public function actualite(): Response
    {
        return $this->render('app/actualite.html.twig', [
        ]);
    }

    #[Route('app/restaurant', name: 'app_restaurant')]
    public function restaurant(): Response
    {
        return $this->render('app/restaurant.html.twig', [
        ]);
    }

    #[Route('app/spa', name: 'app_spa')]
    public function spa(): Response
    {
        return $this->render('app/spa.html.twig', [
        ]);
    }

    #[Route('app/avis', name: 'app_avis')]
    public function avis(): Response
    {
        return $this->render('app/avis.html.twig', [
        ]);
    }
    #[Route('app/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('app/about.html.twig', [
        ]);
    }

    #[Route('app/liens_diver', name: 'app_liens_divers')]
    public function liens(): Response
    {
        return $this->render('app/liens_divers.html.twig', [
        ]);
    }

    #[Route('app/compte', name: 'app_compte')]
    public function compte(): Response
    {
        return $this->render('app/compte.html.twig', [
        ]);
    }    





       
        
        
}
