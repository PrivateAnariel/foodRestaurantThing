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
     */
    public function widgetAction()
    {   
        $baseUrl = 'http://maps.googleapis.com/maps/api/directions/json?';  
        $commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
        $commandes = $commandeRepository->findAll();
        foreach ($commandes as $commande) {
            $query = array(
                        "origin" => "377 des seigneurs, Montreal, h3j0a9",
                        "destination" => $commande->getIdAdresse()->toString(),
                        "durationInTraffic" => true,
                        "waypoints" => $commande->getIdRestaurant()->getAdresse(),
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
            $distance = $distance/1000;

            echo(($distance/1000)." km");
        }die;

        /**

        */
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($query),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        var_dump($result);

        return $this->render('AppBundle:Adresse:AdresseBlock.html.twig', $params);
    }
}