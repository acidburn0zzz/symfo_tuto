<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{

    public function adminAction()
    {

        if (FALSE === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('re_login');
        }

//      if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
//      return $this->redirectToRoute('re_index');
//      return new Response('', 500);
//      }
        else {
        return $this->render('MainBundle:Security:user.html.twig');
        }
    }

    public function userAction()
    {

	if (FALSE === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
	return $this->redirectToRoute('re_login');
      	}

//	if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
//	return $this->redirectToRoute('re_index');
//	return new Response('', 500);
//	}
	else {
        return $this->render('MainBundle:Security:user.html.twig');
        }
    }


    public function logoutAction()
    {
	if ($this->get('security.token_storage')->getToken()->getUser()) {
	$this->get('security.token_storage')->setToken(null);
	$this->addFlash('logout','Logout');
	return $this->redirectToRoute('re_login');
	}
    }



    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        if ($error) {
        $this->addFlash('login','Error Login');
        }


        return $this->render('MainBundle:Security:login.html.twig', array('last_username' => $lastUsername,
                                                                          'error'         => $error));
    }


}
