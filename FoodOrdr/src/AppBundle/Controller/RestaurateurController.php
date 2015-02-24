<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Restaurateur;
use AppBundle\Form\Type\RestaurateurType;
use AppBundle\Form\Type\ConfirmRestaurateurType;

/**
 * @Route("/Restaurateur", name="restaurateur_controller")
 */
class RestaurateurController extends Controller
{
    /**
     * @Route("/Inscription", name="register_restaurateur")
     * @Security("has_role('ROLE_ENT')")
     */
    public function registerAction()
    {
		$params = array();
		$restaurateur = new Restaurateur();
		
		$restaurateurRepo = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');

		$form = $this->createForm(new RestaurateurType(), $restaurateur);

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur = $form->getData();
			$form = $this->createForm(new ConfirmRestaurateurType(), $restaurateur, array( 'action' => '/Restaurateur/Create'));
		}
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurateur:Registration.html.twig', $params);
    }

    	/**
     * @Route("/Create", name="create_restaurateur")
	 * @Method("POST")
     */
    public function createAction()
    {
		$restaurateur = new Restaurateur();
		$form = $this->createForm(new ConfirmRestaurateurType(), $restaurateur);
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur = $form->getData();
			$ent = $this->get('security.context')->getToken()->getUser();
			$restaurateur->setIdEntrepreneur($ent);
			$em = $this->getDoctrine()->getManager();
			
			$em->persist($restaurateur);
			//$compte->setIdRestaurateur($restaurateur);
			//$em->persist($compte);
			
			$em->flush();
			
			$token = new UsernamePasswordToken($restaurateur, null, 'main', $restaurateur->getRoles());
			$this->get('security.token_storage')->setToken($token);
		}
        return $this->redirect($this->generateUrl('home'));
    }
 }