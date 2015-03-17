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
     * @Route("/Nouveau", name="ajouter_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function registerMenu()
    {	
		$params = array();
		$menu = new Menu();
		
		$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$restaurateur = $this->get('security.context')->getToken()->getUser();
		$restaurant = $restaurantRepo->findBy(array('idRestaurant'=>$restaurateur->getIdRestaurant()));
		$form = $this->createForm(new MenuType(), $menu);
		
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$menu = $form->getData();

			$form = $this->createForm(new ConfirmMenuType(), $menu, array('action' => '/Menu/Creer',));
		}
		$params['message'] = "";
		$params['form'] = $form->createView();
        return $this->render('AppBundle:Menu:Registration.html.twig', $params);
        
    }

     /**
     * @Route("/Creer", name="creer_menu")
	 * @Method("POST")
     */
    public function createMenu()
    {
		$menu = new Menu();
		$form = $this->createForm(new ConfirmMenuType(), $menu);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$menu = $form->getData();
			$restaurantRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$restaurateur = $this->get('security.context')->getToken()->getUser();
			$restaurant = $restaurantRepo->findBy(array('idRestaurant'=>$restaurateur->getIdRestaurant()));
			$menu->setIdRestaurant($restaurant[0]);
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($menu);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('show_menu'));
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

     /**
     * @Route("/Edit/{id}", name="edit_item")
     */
    public function editItem($id)
    {
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
    	$item = $itemRepository->findOneBy(array('idItem' => $id ));	
    	$form = $this->createForm(new ItemType(),$item);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$item = $form->getData();
			$form = $this->createForm(new ConfirmItemType(), $item, array( 
																					'action' => '/Menu/Update/'.$id,
																				));
		}
        $params['form'] = $form->createView();
        $params['message'] = "";
        return $this->render('AppBundle:Menu:Registration.html.twig', $params);
    }

    	/**
     * @Route("/Update/{id}", name="update_item")
	 * @Security("has_role('ROLE_REST')")
	 * @Method("POST")
     */
    public function updateAction($id)
    {
		$form = $this->createForm(new ConfirmItemType(), null);
		$form->handleRequest($this->getRequest());

		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
		$user = $this->get('security.context')->getToken()->getUser();
		if ($form->isValid()) {
			$item = $itemRepository->findOneBy(array('idItem' => $id ));
			$item_edit = $form->getData();
			
			$item ->setNom($item_edit->getNom())
					 ->setPrix($item_edit->getPrix())
					 ->setDescription($item_edit->getDescription());
			
			$em = $this->getDoctrine()->getManager();	
			$em->persist($item);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('show_menu'));
    }


     /**
     * @Route("/Delete/{id}", name="delete_item")
     */
    public function supprimerItem($id)
    {
		$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
		$item = $itemRepository->findOneBy(array('idItem' => $id));
		$form = $this->createForm(new ConfirmItemType(), $item, array('action' => '/Menu/SuppConfirmation/'.$id,
																		));

		$message = "** Voulez-vous vraiment supprimer cet item? **";
		$params['message'] = $message;
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Menu:Registration.html.twig', $params);
    }

     /**
     * @Route("/SuppConfirmation/{id}", name="deleteConf_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function deleteConfAction($id)
    {
    	$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
    	$item = $itemRepository->findOneBy(array('idItem' => $id));
		$form = $this->createForm(new ConfirmItemType(), null);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$item_edit = $form->getData();
			
			$itemRepository = $this->get('doctrine')->getRepository('AppBundle:Item');
			$item = $itemRepository->findOneBy(array('idItem' => $id));
			
			
			$em = $this->getDoctrine()->getManager();	
			$em->remove($item);
			$em->flush();
		}

        return $this->redirect($this->generateUrl('show_menu'));
    }
}