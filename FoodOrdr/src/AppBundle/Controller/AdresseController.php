<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/Adresse", name="adresse_controller")
 */
class AdresseController extends Controller
{
    /**
     * @Route("/Inscription", name="ajouter_adresse")
     * @Security("has_role('ROLE_USER')")
     */
    public function ajouterAction()
    {
		
    }


    /**
     * @Route("/Create", name="create_adresse")
	 * @Method("POST")
     */
    public function createAction()
    {
		
    }

	/**
     * @Route("/Show", name="show_adresses")
	 * @Security("has_role('ROLE_USER')")
     */
    public function showAction()
    {
		$user = $this->get('security.context')->getToken()->getUser();
		$adresses = $user->getAdresses();
		return $this->render('AppBundle:Adresse:Listadresses.html.twig',  array('ListeAdresses' => $adresses) );
    }

     /**
     * @Route("/Suppression", name="delete_adresse")
	 * @Method("POST")
     */
        public function deleteAction()
    {	
    	if(!($this->getRequest()->isXmlHttpRequest()))
    	{
    		return $this->redirect($this->generateUrl('home'));
    	}
    	$response = new Response();
		$response->headers->set('Content-Type', 'application/json');
    	$id = $this->getRequest()->get('id');
    	if($id === null){
    		$response->setContent(json_encode(array("responseCode"=>500, "success" => false)));
    		return $response;
    	}
		$adresseRepository = $this->get('doctrine')->getRepository('AppBundle:Adresse');
		$adresse = $adresseRepository->findOneBy(array('idAdresse' => $id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($adresse);
		$em->flush();

		$response->setContent(json_encode(array("responseCode"=>200, "success" => true)));
		return $response;
    }
 }