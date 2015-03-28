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
			if ($restaurateur->getIdRestaurant() == null){
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
			//$compte->setIdRestaurateur($restaurateur);
			//$em->persist($compte);
			
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
			if ($restaurateur->getIdRestaurant() == null){
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
    	$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new ConfirmRestaurateurType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur_edit = $form->getData();
			
			$restoRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$resto = $restoRepository->findOneBy(array('idRestaurant' => $restaurateur_edit->getIdRestaurant()));
			$restaurateur->setNom($restaurateur_edit->getNom())
					 ->setPrenom($restaurateur_edit->getPrenom())
					 ->setTelephone($restaurateur_edit->getTelephone())
					 ->setMdp($restaurateur_edit->getMdp())
					 ->setIdRestaurant($resto);
			
			$em = $this->getDoctrine()->getManager();	
			$em->persist($restaurateur);
			$em->flush();
		}
        return $this->redirect($this->generateUrl('home'));
    }

    // ==================================================================================
    // --------------------------------SUPPRESSION---------------------------------------

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
     * @Route("/SuppConfirmation/{id}", name="deleteC_restaurateur")
	 * @Security("has_role('ROLE_ENT')")
	 * @Method("POST")
     */
    public function deleteCAction($id)
    {
    	$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
    	$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => $id));
		$form = $this->createForm(new ConfirmRestaurateurType());
		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$restaurateur_edit = $form->getData();
			
			$restoRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
			$resto = $restoRepository->findOneBy(array('idRestaurant' => $restaurateur_edit->getIdRestaurant()));
			
			
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

  		$restaurateurRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurateur');
    	$restaurateur = $restaurateurRepository->findOneBy(array('idRestaurateur' => ($user->getIdRestaurateur())));
    	$restaurantRepository = $this->get('doctrine')->getRepository('AppBundle:Restaurant');
    	$commandeRepository = $this->get('doctrine')->getRepository('AppBundle:Commande');
    	$commandes = $commandeRepository->findBy(array('idRestaurant' => $restaurateur->getIdRestaurant()));
    	$params['commandes'] = $commandes;
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
    	$commandes = $commandeRepository->findBy(array('idRestaurant' => $user->getIdRestaurant()));
    	$commande = $commandeRepository->findOneBy(array('idCommande' => $id));
    	$form = $this->createFormBuilder($commande)
			->add('idStatut', 'entity', array( 'class' => 'AppBundle:Statut','required' => true))
            ->add('Mettre a jour', 'submit')
            ->getForm();

        $form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$commande_edit = $form->getData();
			$commande->setIdStatut($commande_edit->getIdStatut());
			$em = $this->getDoctrine()->getManager();	
			$em->persist($commande);
			$em->flush();
			$params['commandes'] = $commandes;
			return $this->render('AppBundle:Commande:showCommande.html.twig', $params);
		}
        $params['form'] = $form->createView();
        $params['commande'] = $commande;
 		return $this->render('AppBundle:Commande:statutCommande.html.twig', $params);
    }
 }