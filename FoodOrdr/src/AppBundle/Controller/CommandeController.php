<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Commande;

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
}