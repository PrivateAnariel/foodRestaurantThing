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
use AppBundle\Form\Type\RestaurateurSelect;

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
		$ent = $this->get('security.context')->getToken()->getUser();

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new RestaurateurType(), $restaurateur);
		
		$form->handleRequest($this->getRequest());

		$message = " ";
		if ($form->isValid()) {
			$restaurateur = $form->getData();
			$resto = $restaurateur->getRestaurants();
			if ($resto[0] == null){
				$message = "** Le restaurateur n'a pas de restaurant associé **";
			}
			$form = $this->createForm(new ConfirmRestaurateurType, $restaurateur, array( 'action' => '/Restaurateur/Create'));
		}
        $params['form'] = $form->createView();
        $params['message'] = $message;
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
			
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }

	/**
     * @Route("/Show", name="show_restaurateurs")
	 * @Security("has_role('ROLE_ENT')")
     */
    public function showAction()
    {
    	$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$user = $this->get('security.context')->getToken()->getUser();
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ENT'))
		{
			$option=array('idEntrepreneur'=>$user->getIdEntrepreneur());
		}
		else
		{
			$option=array('idRestaurateur'=>$user->getIdRestaurateur());
		}

		$restaurateurs = $restaurateurRepository->findBy($option);	
		return $this->render('AppBundle:Restaurateur:ListeRestaurateurs.html.twig',  array('ListeRestaurateurs' =>$restaurateurs) );
    }

    /**
     * @Route("/Edit/{id}", name="edit_restaurateur")
	 * @Security("has_role('ROLE_ENT')")
     */
    public function editAction($id)
    {
		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new RestaurateurType(), $restaurateur);
		$form->remove('courriel');
		$form->add('courriel', 'hidden');
		$form->remove('mdp');
		$form->add('mdp', 'hidden');
		$form->handleRequest($this->getRequest());

		$message = "";
		if ($form->isValid()) {
			$restaurateur = $form->getData();
			$form = $this->createForm(new ConfirmRestaurateurType(), $restaurateur, array( 'action' => '/Restaurateur/Update/'.$id.' '));
			$form->remove('courriel');
			$resto = $restaurateur->getRestaurants();
			if ($resto[0] == null){
				$message = "** Le restaurateur n'a pas de restaurant associé **";
			}
		}
		$params['message'] = $message;
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurateur:Registration.html.twig', $params);
    }
	
	/**
     * @Route("/Update/{id}", name="update_restaurateur")
	 * @Security("has_role('ROLE_ENT')")
	 * @Method("POST")
     */
    public function updateAction($id)
    {
    	$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
    	$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
    	$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new ConfirmRestaurateurType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur_edit = $form->getData();
			$resto = $restaurateur_edit->getRestaurants();
			$restaurateur->setNom($restaurateur_edit->getNom())
					 ->setPrenom($restaurateur_edit->getPrenom())
					 ->setTelephone($restaurateur_edit->getTelephone())
					 ->setMdp($restaurateur_edit->getMdp())
					 ->setRestaurants($resto);
			$em = $this->getDoctrine()->getManager();	
			$em->persist($restaurateur);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }

     /**
     * @Route("/Suppression/{id}", name="delete_restaurateur")
	 * @Security("has_role('ROLE_ENT')")
     */
    public function deleteAction($id)
    {
		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
		$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new RestaurateurType(), $restaurateur);
		$form->remove('courriel');
		$form->add('courriel', 'hidden');
		$form->remove('courriel');
		$form->add('mdp', 'hidden');
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur = $form->getData();
			$form = $this->createForm(new ConfirmRestaurateurType(), $restaurateur, array( 'action' => '/Restaurateur/SuppConfirmation/'.$id.' '));
			$form->remove('courriel');
		}
		$message = "** Voulez-vous vraiment supprimer ce restaurateur? **";
		$params['message'] = $message;
        $params['form'] = $form->createView();
        return $this->render('AppBundle:Restaurateur:Registration.html.twig', $params);
    }

    /**
     * @Route("/SuppConfirmation/{id}", name="confirm_delete_restaurateur")
	 * @Security("has_role('ROLE_ENT')")
	 * @Method("POST")
     */
    public function confirmDeleteAction($id)
    {
    	$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
    	$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new ConfirmRestaurateurType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur_edit = $form->getData();
			
			$em = $this->getDoctrine()->getManager();	
			$em->remove($restaurateur);
			$em->flush();
		}

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/Commandes", name="show_commande")
	 * @Security("has_role('ROLE_REST')")
     */
    public function showCommandeAction()
    {	
    	$user = $this->get('security.context')->getToken()->getUser();
    	$params = array();
    	$params['commandes'] = array();
    	foreach($user->getRestaurants() as $restaurant){
    		foreach($restaurant->getCommandes() as $commande){
	    		if($commande->getStatut()->getIdStatut() != 4){
	    			array_push($params['commandes'], $commande);
	    		}
			}
    	}
    	return $this->render('AppBundle:Commande:showCommande.html.twig', $params);
    }

    /**
     * @Route("/Statut/{id}", name="edit_statut")
	 * @Security("has_role('ROLE_REST')")
     */
    public function statutAction($id)
    {	
    	$user = $this->get('security.context')->getToken()->getUser();
    	$commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
    	$commande = $commandeRepository->findOneBy(array('idCommande' => $id));
    	$restaurants = $user->getRestaurants();
			
    	$form = $this->createFormBuilder($commande)
			->add('statut', 'entity', array( 'class' => 'AppBundle:Statut','required' => true))
            ->add('Mettre a jour', 'submit')
            ->getForm();

        $form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$commande_edit = $form->getData();
			$commande->setStatut($commande_edit->getStatut());
			$em = $this->getDoctrine()->getManager();	
			$em->persist($commande);
			$em->flush();
			$params['restaurants'] = $restaurants;
			return $this->redirect($this->generateUrl('show_commande'));
		}
        $params['form'] = $form->createView();
        $params['commande'] = $commande;
 		return $this->render('AppBundle:Commande:statutCommande.html.twig', $params);
    }
 }