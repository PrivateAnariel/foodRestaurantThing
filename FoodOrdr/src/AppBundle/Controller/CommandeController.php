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
     * @Route("/Distance", name="adresse_widget")
     * @Security("has_role('ROLE_LIVR')")
     */
    public function widgetAction()
    {   
        $listeCommandes = array();
        $user = $this->get('security.context')->getToken()->getUser();
        $baseUrl = 'http://maps.googleapis.com/maps/api/directions/json?';  
        $commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
        $commandes = $commandeRepository->findAll();
        foreach ($commandes as $commande) {
            $query = array(
                        "origin" => $user->getAdresse(),
                        "destination" => $commande->getAdresse()->toString(),
                        "durationInTraffic" => true,
                        "waypoints" => $commande->getRestaurant()->getAdresse(),
                        "optimizeWaypoints" => false,
                        "provideRouteAlternatives" => false,
                        "avoidHighways" => false,
                        "avoidTolls" => true,
                        "region" => "CA"
                    );
            $query = http_build_query($query);
            $url = $baseUrl.$query;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $jsonResponse = curl_exec($curl);
            $response = json_decode($jsonResponse, true);
            $distance = 0;
            if($response['status'] != 'NOT_FOUND') {
                foreach ($response['routes'][0]['legs'] as $leg) {
                    $distance += $leg['distance']['value'];
                }
            }
            array_push($listeCommandes, array(
                                        'info' => $commande,
                                        'directions' => $jsonResponse,
                                        'distance' => $distance/1000
                                        ));
        }
        usort($listeCommandes, function($a,$b){
                                    if ($a['distance'] == $b['distance']) {
                                        return 0;
                                    }
                                    return ($a['distance'] < $b['distance']) ? -1 : 1;
                                });

        return $this->render('AppBundle:Commande:livrerCommande.html.twig', array('listeCommandes' => $listeCommandes));
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
     * @Route("/Show/Restaurant/{id}", name="commander")
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
                            'quantite' => $qty);
                        array_push($lignescommande, $lignecommande);
                    }
                }
                  $params['lignescommande'] = $lignescommande;
                  return $this->render('AppBundle:Commande:AfficherCommande.html.twig', $params);
             }
        $params['items'] = $items;
        $params['restaurant'] = $restaurant;
        return $this->render('AppBundle:Client:Commande.html.twig', $params);
    }

        /**
     * @Route("/Show/Afficher/{id}", name="afficher_commande")
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

        //Si la methode de retour est un post
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
}