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
 }