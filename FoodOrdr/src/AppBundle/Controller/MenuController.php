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
use AppBundle\Form\Type\ConfirmMenuType;
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
     * @Route("/Nouveau/{id}", name="ajouter_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function registerMenu($id)
    {	
    	$response;
		$params = array();
		$menu = new Menu();
		$menu->addItem(new Item());
		
		$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$restaurateur = $this->get('security.context')->getToken()->getUser();
		$restaurant = $restaurantRepo->findBy(array('idRestaurant'=>$id));
		$form = $this->createForm(new MenuType(), $menu, array(
																'em' => $this->getDoctrine()->getManager(),
															));
		
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$menu = $form->getData();
			$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$restaurateur = $this->get('security.context')->getToken()->getUser();
			$restaurant = $restaurantRepo->findOneBy(array('idRestaurant'=>$id));
			$em = $this->getDoctrine()->getManager();
			$em->persist($menu);
			$em->flush();

			$restaurant->setIdMenu($menu);
			$em->persist($restaurant);
			$em->flush();
			$response = $this->redirect($this->generateUrl('show_menu'));
		}
		else {
			$params['message'] = "";
			$params['form'] = $form->createView();
	        $response = $this->render('AppBundle:Menu:Nouveaumenu.html.twig', $params);
	    }
	    return $response;
        
    }


    /**
     * @Route("/Show", name="show_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function showMenu()
    {
		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
		$user = $this->get('security.context')->getToken()->getUser();

		$idRestaurateur = $user->getIdRestaurateur();
		$restaurants =  $restaurantRepository->findBy(array('idRestaurateur'=>$idRestaurateur));
		$menus = array();
		foreach ($restaurants as $restaurant) {
			$menu = $menuRepository->findOneBy(array('idMenu'=>$restaurant->getIdMenu()));
			if (isset($menu)){
				array_push($menus, $menu);
			}
		}
		
		$items = array();
		foreach ($menus as $menu) {
			if(isset($menu)){
				$item = $itemRepository->findBy(array('menu'=>$menu->getIdMenu()));
				if (isset($item)){
					array_push($items, $item);
				}
			}
		}
		return $this->render('AppBundle:Restaurant:showRestaurant.html.twig',  array('restaurants' =>$restaurants,'menus' =>$menus) );
    }

     /**
     * @Route("/AjoutItem", name="ajouter_item")
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
    public function createItem()
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