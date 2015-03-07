<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Restaurant;
use AppBundle\Form\Type\RestaurantType;
use AppBundle\Form\Type\ConfirmRestaurantType;

/**
 * @Route("/Restaurant", name="restaurant_controller")
 */
class RestaurantController extends Controller
{
    /**
     * @Route("/Inscription", name="register_restaurant")
     * @Security("has_role('ROLE_ENT')")
     */
    public function registerAction()
    {
		$params = array();
		$restaurant = new Restaurant();
		
		$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$ent = $this->get('security.context')->getToken()->getUser();

		$form = $this->createForm(new RestaurantType(), $restaurant);
		
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurant = $form->getData();
			$form = $this->createForm(new ConfirmRestaurantType(), $restaurant, array( 'action' => '/Restaurant/Create'));
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurant:Registration.html.twig', $params);
    }


    	/**
     * @Route("/Create", name="create_restaurant")
	 * @Method("POST")
     */
    public function createAction()
    {
		$restaurant = new Restaurant();
		$form = $this->createForm(new ConfirmRestaurantType(), $restaurant);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurant = $form->getData();
			$ent = $this->get('security.context')->getToken()->getUser();
			$restaurant->setIdEntrepreneur($ent);
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($restaurant);
			//$compte->setIdRestaurateur($restaurateur);
			//$em->persist($compte);
			
			$em->flush();
			
			// $token = new UsernamePasswordToken($restaurant, null, 'main', $restaurant->getRoles());
			// $this->get('security.token_storage')->setToken($token);
		}
        return $this->redirect($this->generateUrl('home'));
    }

	/**
     * @Route("/Edit/{id}", name="edit_restaurant")
	 * @Security("has_role('ROLE_ENT')")
     */
    public function editAction($id)
    {	
    	$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
    	$restaurant = $restaurantRepository->findOneBy(array('idRestaurant' => $id ));	
    	$form=$this->createForm(new RestaurantType(),$restaurant);

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurant = $form->getData();
			$form = $this->createForm(new ConfirmRestaurantType(), $restaurant, array( 'action' => '/Restaurant/Update'));
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurant:Registration.html.twig', $params);
    }

	/**
     * @Route("/Show", name="show_restaurants")
	 * @Security("has_role('ROLE_REST')")
     */
    public function showAction()
    {
    	$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$user = $this->get('security.context')->getToken()->getUser();
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ENT'))
		{
			$option=array('idEntrepreneur'=>$user->getIdEntrepreneur());
			
		}
		else
		{
			$option=array('idRestaurant'=>$user->getIdRestaurant());
		}

		$restaurants = $restaurantRepository->findBy($option);	
		 return $this->render('AppBundle:Restaurant:Listrestaurant.html.twig',  array('ListeRestaurant' =>$restaurants) );
    }

    	/**
     * @Route("/Update", name="update_restaurant")
	 * @Security("has_role('ROLE_ENT')")
	 * @Method("POST")
     */
    public function updateAction()
    {
		$form = $this->createForm(new ConfirmRestaurantType());
		$form->handleRequest($this->getRequest());
		$restaurant = new Restaurant();
		if ($form->isValid()) {
			$restaurant_edit = $form->getData();
			
			$restaurant->setNom($restaurant_edit->getNom())
					 ->setAdresse($restaurant_edit->getAdresse())
					 ->setTelephone($restaurant_edit->getTelephone());
			
			$em = $this->getDoctrine()->getManager();	
			$em->persist($restaurant);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }



     /**
     * @Route("/Suppression/{id}", name="delete_restaurant")
	 * @Security("has_role('ROLE_ENT')")
     */
        public function deleteAction($id)
    {
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$restaurant = $restaurantRepository->findOneBy(array('idRestaurant' => $id));
		$form = $this->createForm(new RestaurantType(), $restaurant);
		//$form->remove('courriel');
		$form->add('nom', 'hidden');
		$form->add('adresse', 'hidden');
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurant = $form->getData();
			$form = $this->createForm(new ConfirmRestaurantType(), $restaurant, array( 'action' => '/Restaurant/SuppConfirmation/'.$id.' '));
			$form->remove('nom');
		}
		$message = "** Voulez-vous vraiment supprimer ce restaurant? **";
		$params['message'] = $message;
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurant:Registration.html.twig', $params);
    }


       /**
     * @Route("/SuppConfirmation/{id}", name="deleteC_restaurant")
	 * @Security("has_role('ROLE_ENT')")
	 * @Method("POST")
     */
    public function deleteCAction($id)
    {
    	$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
    	$restaurant = $restaurantRepository->findOneBy(array('idRestaurant' => $id));
		$form = $this->createForm(new ConfirmRestaurantType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurant_edit = $form->getData();
			
			$restoRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$resto = $restoRepository->findOneBy(array('idRestaurant' => $restaurant_edit->getIdRestaurant()));
			
			
			$em = $this->getDoctrine()->getManager();	
			$em->remove($restaurant);
			$em->flush();
		}

        return $this->redirect($this->generateUrl('home'));
    }
 }