<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{


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
