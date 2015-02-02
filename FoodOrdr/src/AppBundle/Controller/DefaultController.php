<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction($message = null)
    {
		$params = array();
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $params['authenticated'] = true;
		}
		$userToken = $this->get('security.token_storage')->getToken()->getUser();
		$repository = $this->get('doctrine_mongodb')
			->getRepository('AppBundle:User');
		$user = $repository->find($userToken->getId());
		$params['name'] = $user->getFirstName();
		
		if($message)
		{
			$params['message'] = $message;
		}
        return $this->render('default/index.html.twig', $params);
    }
}
