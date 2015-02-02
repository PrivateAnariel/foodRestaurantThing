<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Document\UserAccount;
use AppBundle\Document\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Form\Type\ConfirmUserType;


class UserController extends Controller
{
    /**
     * @Route("/RegisterUser", name="user_registration")
     */
    public function registerAction()
    {
		$securityContext = $this->container->get('security.context');
		$view = 'user/register.html.twig';
		$params = array();
		$user = new User();
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $params['authenticated'] = true;
		}
		
		$dm = $this->get('doctrine_mongodb')->getManager();

		$form = $this->createForm(new UserType(), $user);

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			$user = $form->getData();
			$form = $this->createForm(new ConfirmUserType(), $user, array( 'action' => '/User/Submit/Create'));
		}
        $params['form'] = $form->createView();
        return $this->render($view, $params);
    }
	
	/**
     * @Route("/User/Submit/{submitType}", name="user_submit")
     */
	public function submitAction($submitType) {
		
		$securityContext = $this->container->get('security.context');
		$params = array();
		$user = new User();
		
		$dm = $this->get('doctrine_mongodb')->getManager();

		$form = $this->createForm(new ConfirmUserType(), $user);
		$form->handleRequest($this->getRequest());
		
		$user = $form->getData();
		return new Response($submitType);
		if($submitType == 'Create')
		{
			$account = new UserAccount();
			$dm->persist($account);
			$user->setAccount($account);
			$dm->persist($user);
			$message  = 'User sucessfully created, you are now logged in.';
			$token = new UsernamePasswordToken($user, null, 'members', $user->getRoles());
			$this->get('security.context')->setToken($token);
			$this->get('session')->set('_security_default', serialize($token));
		} else {
			$dm->persist($user);
			$message = 'User sucessfully modified';
		}
		
		$dm->flush();

		return $this->forward('AppBundle:Default:index', array('message'  => $message));
	}
	
	/**
     * @Route("/DisplayUser", name="display_user")
     */
    public function displayAllAction()
    {
		$params = array();
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $params['authenticated'] = true;
		}
		$repository = $this->get('doctrine_mongodb')
        ->getRepository('AppBundle:User');
		$users = $repository->findAll();
		if (!$users) {
			throw $this->createNotFoundException('No user found');
		}
		
		foreach ($users as $user) {
		$params[] = array(
			"email" => $user->getUsername(),
			"password" => $user->getPassword(),
			"id" => $user->getId(),
			);
		}
		
		return new Response(print_r($params, true));
    }
	 /**
     * @Route("/ModifyUser", name="user_modification")
     */
    public function modifyAction()
    {
		$view = 'user/register.html.twig';
		$params = array();
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $params['authenticated'] = true;
		}
		$userToken = $this->get('security.token_storage')->getToken()->getUser();
		$repository = $this->get('doctrine_mongodb')
			->getRepository('AppBundle:User');
		$user = $repository->find($userToken->getId());
		
		$form = $this->createForm(new UserType(), $user);
		$form->remove('password');

		$form->handleRequest($this->getRequest());

		if ($form->isValid()) {
			/*$user = $form->getData();
			$form = $this->createForm(new ConfirmUserType(), $user, array( 'action' => '/User/Submit/Update'));*/
			$user = $form->getData();

			$dm = $this->get('doctrine_mongodb')->getManager();
			$dm->persist($user);
			$dm->flush();
			return $this->forward('AppBundle:Default:index', array('message'  => 'User sucessfully modified'));
		}
        $params['form'] = $form->createView();
        return $this->render($view, $params);
    }
}
