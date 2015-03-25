<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\Adresse;
use AppBundle\Form\Type\AdresseType;

/**
 * @Route("/Adresse", name="adresse_controller")
 */
class AdresseController extends Controller
{
    /**
     * @Route("/Nouvelle", name="ajouter_adresse")
     * @Security("has_role('ROLE_USER')")
     */
    public function ajouterAction()
    {
        $params = array();
        $user = $this->get('security.context')->getToken()->getUser();
        $adresse = new Adresse();
        $adresse->setClient($user);
        $form = $this->createForm(new AdresseType(), $adresse, array('action' => $this->generateUrl('ajouter_adresse'),
                                                                        'em' => $this->getDoctrine()->getManager()));
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $adresse = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();
        } elseif(!$this->getRequest()->get('displayButton')) {
            $form->add('save','submit');
            $params['form'] = $form->createView();
        }
        return $this->render('AppBundle:Adresse:NouvelleAdresse.html.twig', $params);
    }


    /**
     * @Route("/Widget", name="adresse_widget")
     */
    public function widgetAction()
    {
		return $this->render('AppBundle:Adresse:AdresseBlock.html.twig');
    }

	/**
     * @Route("/Show", name="show_adresses")
	 * @Security("has_role('ROLE_USER')")
     */
    public function showAction()
    {
		$user = $this->get('security.context')->getToken()->getUser();
		$adresses = $user->getAdresses();
        $params = array('ListeAdresses' => $adresses);
		return $this->render('AppBundle:Adresse:Listadresses.html.twig', $params);
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