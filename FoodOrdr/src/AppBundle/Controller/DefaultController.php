<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
		$clientRepository = $this->get('doctrine')->getRepository('AppBundle:Client');
		$clients = $clientRepository->findAll();
		$name = $clients[0]->getCourriel()." ".$clients[0]->getMdp();
		$params = array("hello" => $name);
        return $this->render('default/index.html.twig', $params);
    }
}
