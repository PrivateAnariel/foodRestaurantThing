<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Client;
use AppBundle\Entity\Compte;
use AppBundle\Form\Type\ClientType;
use AppBundle\Form\Type\ConfirmClientType;

/**
 * @Route("/Client", name="client_controller")
 */
class ClientController extends Controller
{
    /**
     * @Route("/Inscription", name="client_registration")
     */
    public function registerAction()
    {
		$params = array();
		$client = new Client();
		
		$clientRepo = $this->get('doctrine')->getRepository('AppBundle:Client');

		$form = $this->createForm(new ClientType(), $client);

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			$form = $this->createForm(new ConfirmClientType(), $client, array( 'action' => '/Client/Create'));
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Client:Registration.html.twig', $params);
    }
	
	/**
     * @Route("/Create", name="create_client")
	 * @Method("POST")
     */
    public function createAction()
    {
		$client = new Client();
		$form = $this->createForm(new ConfirmClientType(), $client);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			//$compte = new Compte();
			
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($client);
			//$compte->setIdClient($client);
			//$em->persist($compte);
			
			$em->flush();
			
			$token = new UsernamePasswordToken($client, null, 'main', $client->getRoles());
			$this->get('security.token_storage')->setToken($token);
		}
        return $this->redirect($this->generateUrl('home'));
    }
	
	/**
     * @Route("/Edit", name="edit_client")
	 * @Security("has_role('ROLE_USER')")
     */
    public function editAction()
    {
		$client = $this->get('security.context')->getToken()->getUser();
		$form = $this->createForm(new ClientType(), $client);
		$form->remove('courriel');
		$form->remove('mdp');
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			$form = $this->createForm(new ConfirmClientType(), $client, array( 'action' => '/Client/Update'));
			$form->remove('courriel');
			$form->remove('mdp');
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle::modif.html.twig', $params);
    }
	
	/**
     * @Route("/Update", name="update_client")
	 * @Security("has_role('ROLE_USER')")
	 * @Method("POST")
     */
    public function updateAction()
    {
		$client = $this->get('security.context')->getToken()->getUser();
		$form = $this->createForm(new ConfirmClientType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client_edit = $form->getData();
			
			$client->setNom($client_edit->getNom())
					 ->setPrenom($client_edit->getPrenom())
					 ->setDatenaissance($client_edit->getDatenaissance())
					 ->setAdresse($client_edit->getAdresse())
					 ->setTelephone($client_edit->getTelephone());
			
			$em = $this->getDoctrine()->getManager();	
			$em->persist($client);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/Edit", name="passer_commande")
	 * @Security("has_role('ROLE_USER')")
     */
    public function showRestaurant()
    {
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$user = $this->get('security.context')->getToken()->getUser();
	
		return $this->render('AppBundle:Restaurant:ListRestaurant.html.twig',  array('ListeRestaurant' =>$restaurantRepository) );
    }
}
