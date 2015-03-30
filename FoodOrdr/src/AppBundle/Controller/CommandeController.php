<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Commande;
use AppBundle\Entity\LigneCommande;

/**
 * @Route("/Commande", name="commande_controller")
 */
class CommandeController extends Controller
{   
    /**
     * @Route("/Accepter/{id}", name="accepter_commande")
     * @Security("has_role('ROLE_LIVR')")
     */
    public function accepterAction($id)
    {
        $commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
        $commande = $commandeRepository->findOneBy(array('idCommande' => $id));
        $statutRepository = $this->get('doctrine')->getRepository('AppBundle:Statut');
        $commande->setStatut($statutRepository->findOneBy(array('idStatut' => 4)));
        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        return $this->render('default/index.html.twig', array('message' => "Vous avez accepté la commade ".$commande->getIdCommande()));
    }

    /**
     * @Route("/Distance", name="commande_distance")
     * @Security("has_role('ROLE_LIVR')")
     */
    public function distanceAction()
    {   
        $listeCommandes = array();
        $user = $this->getUser();
        $baseUrl = 'http://maps.googleapis.com/maps/api/distancematrix/json?';  
        $commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
        $commandes = $commandeRepository->findAll();
        foreach ($commandes as $commande) {
            if($commande->getStatut()->getIdStatut() == 3){
                $query = "origins=".str_replace(' ', '+', $commande->getRestaurant()->getAdresse());
                $query = $query."&destinations=".str_replace(' ', '+', $user->getAdresse()."|".$commande->getAdresse()->toString());
                $url = $baseUrl.$query;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $jsonResponse = curl_exec($curl);
                $response = json_decode($jsonResponse, true);
    
                $distance = 0;
                $duration = 0;            
                if($response['status'] != 'NOT_FOUND') {
                    foreach ($response['rows'] as $row) {
                        foreach ($row['elements'] as $element) {
                            $distance += $element['distance']['value'];
                            $duration += $element['duration']['value'];
                        }
                    }
                }
                array_push($listeCommandes, array(
                                            'info' => $commande,
                                            'distance' => round($distance/1000,2),
                                            'duration' => gmdate("H:i:s", $duration)
                                            ));
            }
        }
        usort($listeCommandes, function($a,$b){
                                    if ($a['distance'] == $b['distance']) {
                                        return 0;
                                    }
                                    return ($a['distance'] < $b['distance']) ? -1 : 1;
                                });
        $params = array('listeCommandes' => $listeCommandes, 'adresseLivreur' => $user->getAdresse());
        return $this->render('AppBundle:Commande:livrerCommande.html.twig', $params);
    }

    /**
     * @Route("/Show", name="choisir_resto")
     * @Security("has_role('ROLE_USER')")
     */
    public function choisirAction()
    {
        $restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
        $restaurants = $restaurantRepository->findAll();
        return $this->render('AppBundle:client:showRestaurant.html.twig',  array('ListeRestaurant' =>$restaurants));
    }

      /**
     * @Route("/Show/Restaurant/{id}", name="choisir_items")
     * @Security("has_role('ROLE_USER')")
     */
    public function passerAction($id)
    {
        $restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
        $menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
        $itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
        $restaurant = $restaurantRepository->findOneBy(array('idRestaurant'=>$id));
        $menu = $menuRepository->findOneBy(array('idMenu'=>$restaurant->getIdMenu()));
        $items = $itemRepository->findBy(array('menu'=>$menu->getIdMenu()));


        $params['restaurant'] = $restaurant;

        //Si la methode de retour est un post
        $lignescommande = Array();
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST'){
            $datas = $this->getRequest()->request->all();
            foreach ($datas as $id => $qty) {
                if ($qty != 0){
                    $itemTempo = $itemRepository->findOneBy(array('idItem'=>$id));
                    $lignecommande = array('nom'=>$itemTempo->getNom(), 
                                            'prix'=>$itemTempo->getPrix(),
                                            'quantite' => $qty
                                        );
                    array_push($lignescommande, $lignecommande);
                }
            }
            $params['lignescommande'] = $lignescommande;
            return $this->render('AppBundle:Commande:AfficherCommande.html.twig', $params);
        }
        $params['items'] = $items;
        $params['restaurant'] = $restaurant;
        return $this->render('AppBundle:Commande:Commande.html.twig', $params);
    }

    /**
     * @Route("/Afficher/{id}", name="afficher_commande")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function afficherAction($id)
    {
        $restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
        $menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
        $itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
        $restaurant = $restaurantRepository->findOneBy(array('idRestaurant'=>$id));
        $menu = $menuRepository->findOneBy(array('idMenu'=>$restaurant->getIdMenu()));
        $items = $itemRepository->findBy(array('menu'=>$menu->getIdMenu()));

        $params['restaurant'] = $restaurant;

        $lignescommande = Array();
        $request = $this->getRequest();
        $datas = $this->getRequest()->request->all();
        $prix = 0;
        foreach ($datas as $id => $qty) {
            if ($qty != 0 && $qty != null){
                $itemTempo = $itemRepository->findOneBy(array('idItem'=>$id));
                $lignecommande = array('nom'=>$itemTempo->getNom(), 
                    'prix'=>$itemTempo->getPrix(),
                    'quantite' => intval($qty),
                    'id' => $id);
                array_push($lignescommande, $lignecommande);
                $prix += intval($qty) * $itemTempo->getPrix();
            }
        }
        $params['lignescommande'] = $lignescommande;
        $params['prix'] = $prix;
        return $this->render('AppBundle:Commande:AfficherCommande.html.twig', $params);
    }

    /**
     * @Route("/Soumettre", name="soumettre_commande")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function soumettreAction()
    {
        $commande = new Commande();
        $commande->setIdClient($this->getUser());

        //set status
        $statutRepository = $this->get('doctrine')->getRepository('AppBundle:Statut');
        $commande->setStatut($statutRepository->findOneBy(array('idStatut' => 1)));

        //get form data
        $data = $this->getRequest()->request->all();
        
        //set adresse
        $adresseRepository = $this->get('doctrine')->getRepository('AppBundle:Adresse');
        $commande->setAdresse($adresseRepository->findOneBy(array('idAdresse' => $data['adresse'])));
        unset($data['adresse']);

        //set restaurant
        $restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
        $commande->setIdRestaurant($restaurantRepository->findOneBy(array('idRestaurant' => $data['restaurant'])));
        unset($data['restaurant']);

        //set date
        date_default_timezone_set("America/Montreal");
        $date = new \DateTime();
        $date->setTimestamp(time());
        $dateString = "";
        $format = "";
        if($data['dateLivraison'] != null){
            $dateString .= $data['dateLivraison']." ";
            $format .= 'Y-m-d ';
        }
        unset($data['dateLivraison']);
        if($data['heureLivraison'] != null){
            $dateString .= $data['heureLivraison'];
            $format .= 'H:i';
        }
        unset($data['heureLivraison']);
        if($dateString != null){
            $dateInput = new \DateTime();
            $dateInput = $dateInput->createFromFormat($format, $dateString);
            if($date < $dateInput){
                $date = $dateInput;
            }
        }
        $commande->setDateLivraison($date);

        //set items
        $itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
        foreach ($data as $id => $qty) {
            $lc = new LigneCommande();
            $lc->setIdItem($itemRepository->findOneBy(array('idItem'=>$id)));
            $lc->setQuantite($qty);
            $commande->addLigneCommande($lc);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        return $this->redirect($this->generateUrl('confirmation_commande', array('id' => $commande->getIdCommande())));
    }

    /**
     * @Route("/Confirmation/{id}", name="confirmation_commande")
     * @Security("has_role('ROLE_USER')")
     */
    public function confirmerAction($id)
    {   
        $params = array();
        $commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
        $commande = $commandeRepository->findOneBy(array('idCommande' => $id));
        $params['commande'] = $commande;
        $prix = 0;
        foreach ($commande->getLigneCommandes() as $line) {
            $prix += $line->getIdItem()->getPrix()*$line->getQuantite();
        }
        $params['prix'] = $prix;
        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject('Confirmation de votre commande')
            ->setFrom('foodordr.sender@gmail.com')
            ->setTo($this->getUser()->getUsername())
            ->setBody(
                $this->renderView(
                    'AppBundle:Commande:Details.html.twig',
                    $params
                ),
                'text/html'
            );
        $mailer->send($message);

        return $this->render('AppBundle:Commande:ConfirmationCommande.html.twig', array('params' => $params));
    }
}