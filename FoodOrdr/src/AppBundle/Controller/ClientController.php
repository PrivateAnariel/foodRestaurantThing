<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Client;
use AppBundle\Entity\Adresse;
use AppBundle\Entity\Commande;
use AppBundle\Entity\LigneCommande;
use AppBundle\Form\Type\CommandeType;
use AppBundle\Form\Type\ConfirmCommandeType;
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
		$client->addAdress(new Adresse());
		
		$clientRepo = $this->get('doctrine')->getRepository('AppBundle:Client');

		$form = $this->createForm(new ClientType(), $client, array(
																'em' => $this->getDoctrine()->getManager(),
															));
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			$form = $this->createForm(new ConfirmClientType(), $client, array( 'em' => $this->getDoctrine()->getManager(),
																				'action' => '/Client/Create'));
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
		$form = $this->createForm(new ConfirmClientType(), $client, array( 'em' => $this->getDoctrine()->getManager()));
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($client);
			
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
		$form = $this->createForm(new ClientType(), $client, array(
																'em' => $this->getDoctrine()->getManager(),
															));
		$form->remove('courriel');
		$form->remove('mdp');
		$form->remove('adresses');
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client = $form->getData();
			$form = $this->createForm(new ConfirmClientType(), $client, array( 'action' => '/Client/Update',
																				'em' => $this->getDoctrine()->getManager(),
																			));
			$form->remove('courriel');
			$form->remove('mdp');
			$form->remove('adresses');
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Client:modif.html.twig', $params);
    }
	
	/**
     * @Route("/Update", name="update_client")
	 * @Security("has_role('ROLE_USER')")
	 * @Method("POST")
     */
    public function updateAction()
    {
		$client = $this->get('security.context')->getToken()->getUser();
		$form = $this->createForm(new ConfirmClientType(), null, array( 'action' => '/Client/Update',
																				'em' => $this->getDoctrine()->getManager(),
																			));
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$client_edit = $form->getData();
			var_dump($client_edit);
			$client->setNom($client_edit->getNom())
					 ->setPrenom($client_edit->getPrenom())
					 ->setDatenaissance($client_edit->getDatenaissance())
					 ->setTelephone($client_edit->getTelephone());
			$em = $this->getDoctrine()->getManager();
			$em->persist($client);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/Commande", name="choisir_resto")
	 * @Security("has_role('ROLE_USER')")
     */
    public function choisirResto()
    {
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$restaurants = $restaurantRepository->findAll();
		return $this->render('AppBundle:client:showRestaurant.html.twig',  array('ListeRestaurant' =>$restaurants));
    }

      /**
     * @Route("/Commande/Restaurant/{id}", name="commander")
	 * @Security("has_role('ROLE_USER')")
     */
    public function passerCommande($id)
    {
		$params = array();
		$commande = new Commande();
		$lignecommande = new LigneCommande();
		
		$clientRepo = $this->get('doctrine')->getRepository('AppBundle:Client');
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
		$restaurant = $restaurantRepository->findBy(array('idRestaurant'=>$id));
		$menu = $menuRepository->findBy(array('idRestaurant'=>$id));
		$items = $itemRepository->findBy(array('menu'=>$menu[0]->getIdMenu()));


		$form = $this->createFormBuilder($lc)
			->add('item', 'submit')
            ->add('Enregistrer', 'submit')
            ->getForm();

		if ($form->isValid()) {
			$client = $form->getData();
			$form = $this->createForm(new ConfirmCommandeType(), $client, array( 'em' => $this->getDoctrine()->getManager(),
																				'action' => '/Commande/Create'));
		}
        $params['form'] = $form->createView();
        $params['items'] = $items;
        return $this->render('AppBundle:Client:Commande.html.twig', $params);
    }
}
