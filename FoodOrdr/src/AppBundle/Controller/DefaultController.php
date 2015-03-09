<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
            ->add('mdp', 'password', array(
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
            ->getForm();
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            
            $data = $form->getData();
        }
        $params = array("hello" => "test");
        return $this->render('default/index.html.twig', $params);
    }
}
