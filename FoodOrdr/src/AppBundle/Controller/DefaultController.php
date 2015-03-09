<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
		$clientRepository = $this->get('doctrine')->getRepository('AppBundle:Client');
		$clients = $clientRepository->findAll();
		$name = $clients[0]->getCourriel()." ".$clients[0]->getMdp();
		$params = array("hello" => $name);
        return $this->render('default/index.html.twig', $params);
    }
    /**
     * @Route("/NouveauMdp", name="client_mdp")
     * @Security("has_role('ROLE_USER')")
     */
    public function newMdpAction() {
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('vieux_mdp', 'password', array(
                'constraints' => array(
                    new NotBlank(),
                    new UserPassword(),
                ),
            ))
            ->add('nouveauMdp', 'repeated', array(
               'first_name' => 'nouveau_mdp',
               'second_name' => 'confirm_mdp',
               'type' => 'password',
               'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('confirmer', 'submit')
            ->getForm();
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $data = $form->getData();
            $user = $this->get('security.context')->getToken()->getUser();
            $user->setMdp($data['nouveauMdp']);

            $em = $this->getDoctrine()->getManager();   
            $em->persist($user);
            $em->flush();
            
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
        }
        $params = array("form" => $form->createView());
        return $this->render('AppBundle:Client:Registration.html.twig', $params);
    }
}
