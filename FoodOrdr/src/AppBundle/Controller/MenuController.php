<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Form\Type\ItemType;
use AppBundle\Form\Type\ConfirmItemType;
use AppBundle\Form\Type\MenuType;
use AppBundle\Entity\Restaurateur;
use AppBundle\Entity\Restaurant;
use AppBundle\Entity\Menu;
use AppBundle\Entity\Item;

/**
 * @Route("/Menu", name="menu_controller")
 */
class MenuController extends Controller
{	
	/**
     * @Route("/Creer", name="creer_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function createMenu()
    {
		$params = array();
		$menu = new Menu();
		
		$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$restaurateur = $this->get('security.context')->getToken()->getUser();
		$restaurant = $restaurantRepo->findBy(array('idRestaurant'=>$restaurateur->getIdRestaurant()));
		$form = $this->createForm(new MenuType(), $restaurant, array(
																			'em' => $this->getDoctrine()->getManager(),
																			));
		
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$menu = $form->getData();

			$menu->setIdRestaurant($restaurant);
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($menu);
			$em->flush();
		}
		 return $this->redirect($this->generateUrl('show_menu'));
        
    }

    /**
     * @Route("/Menu", name="show_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function showMenu()
    {
		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
		$user = $this->get('security.context')->getToken()->getUser();

		if ($this->get('security.authorization_checker')->isGranted('ROLE_REST'))
		{
			$option = array('idRestaurant'=>$user->getIdRestaurant());
		}
		else
		{
			$option=array('idRestaurant'=>$user->getIdRestaurant());
		}

		$restaurant = $restaurantRepository->findBy($option);
		$menu = $menuRepository->findBy(array('idRestaurant'=>$user->getIdRestaurant()));
		$items = null;
		if(isset($menu[0])){
			$items = $itemRepository->findBy(array('idMenu'=>$menu[0]->getIdMenu()));
		}
		return $this->render('AppBundle:Restaurant:showRestaurant.html.twig',  array('restaurant' =>$restaurant,'menu' =>$menu,'items' =>$items) );
    }

     /**
     * @Route("/Menu/{id}", name="ajouter_item")
	 * @Security("has_role('ROLE_REST')")
     */
    public function ajouterItem($id)
    {	
		$params = array();
		$item = new Item();
		
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new ItemType(), $item);
		
		$form->handleRequest($this->getRequest());

		$message = " ";
		if ($form->isValid()) {
			if ($item->getDescription() == null){
				$message = "** L'item n'a pas de description **";
			}
			$form = $this->createForm(new ConfirmItemType, $item, array( 'action' => '/Menu/Create'));
		}
        $params['form'] = $form->createView();
        $params['message'] = $message;
        return $this->render('AppBundle:Menu:Registration.html.twig', $params);
    }

       	/**
     * @Route("/Create", name="create_item")
	 * @Method("POST")
     */
    public function createAction()
    {
		$item = new Item();
		$form = $this->createForm(new ConfirmItemType(), $item);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$item = $form->getData();
			$rest = $this->get('security.context')->getToken()->getUser();
			$option = array('idRestaurant'=>$rest->getIdRestaurant());
			$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');

			$restaurant = $restaurantRepository->findBy($option);
			$menu = $menuRepository->findBy(array('idRestaurant'=>$rest->getIdRestaurant()));

			$item->setIdMenu($menu[0]);
			$em = $this->getDoctrine()->getManager();
			var_dump($item);
			$em->persist($item);
			
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }
}