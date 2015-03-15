<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Restaurateur;
use AppBundle\Entity\Restaurant;
use AppBundle\Entity\Menu;

/**
 * @Route("/Menu", name="menu_controller")
 */
class MenuController extends Controller
{
    /**
     * @Route("/Menu", name="show_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function showMenu()
    {
		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
		$menuRepository = $this->get('doctrine')->getRepository('AppBundle:Menu');
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
		
		return $this->render('AppBundle:Restaurant:showRestaurant.html.twig',  array('restaurant' =>$restaurant,'menu' =>$menu) );
    }

     /**
     * @Route("/Menu/{id}", name="gerer_menu")
	 * @Security("has_role('ROLE_REST')")
     */
    public function gererMenu($id)
    {
			
		
		return $this->render('AppBundle:Restaurant:showRestaurant.html.twig',  array('restaurant' =>$restaurant) );
    }
}