<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Validator\Mapping\ClassMetadata;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Regex;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }



     public function contactAction(Request $request)
    {

	$firstname = $lastname = $email = $object = $message =  NULL;

	$contact_error_firstnamemin = NULL;

	$form = $this->createFormBuilder()

	->add('firstname', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.firstname'
))
									,new Length(array('min' => 3,
											  'max' => 10,
											  //'minMessage' => 'contact.error.firstnamemin,
											  //'maxMessage' => 'contact.error.firstnamemax'
 )))))

        ->add('lastname', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
))
									,new Length(array('min' => 3,
                                                                                          'max' => 10,
                                                                                          //'minMessage' => 'contact.error.lastnamemin',
                                                                                          //'maxMessage' => 'contact.error.lastnamemax' 
)))))


        ->add('email', TextType::class,  array('constraints' => array(new Assert\Email(array('checkMX' => true)),
	   							      new NotBlank(),)))

//        ->add('email', EmailType::class, array('constraints' => array(new Assert\Email(array(//'message' => 'contact.error.email',
  //          											'checkMX' => true)))))
/*
	->add('object', ChoiceType::class, array('choices' => array('' => '','Autre' => "Autre",'Bug' => "Bug", 'Demande' => "Demande"))
					 , array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
)))))
*/
	->add('object', ChoiceType::class, array('choices' => array('' => '','Autre' => "Autre",'Bug' => "Bug", 'Demande' => "Demande")),
					   array('constraints' => array(new Length(array('min' => 3)))))

        ->add('message', TextareaType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.messagenotblank'
))
								          ,new Length(array('min' => 8,
                                                                                            'max' => 10,
                                                                                           // 'minMessage' => 'contact.error.messagemin',
                                                                                           // 'maxMessage' => 'contact.error.messagemax' 
)))))

        ->add('send', SubmitType::class , array('label' => 'Envoyer'))
	->add('reset', ResetType::class , array('label' => 'Envoyer'))
        ->getForm();


	$form->handleRequest($request);

	if ( $form->isValid() ){
		if ( $request->isMethod('POST') ){

		$request = Request::createFromGlobals();

		$firstname = $form["firstname"]->getData();
        	$lastname = $form["lastname"]->getData();
        	$email = $form["email"]->getData();
        	$object = $form["object"]->getData();
        	$message = $form["message"]->getData();

		$message = \Swift_Message::newInstance()

                ->setSubject($object)
                ->setFrom(array($email))
                ->setTo('youremailadress@yourdomain.com')
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody($this->container->get('templating')->render('MainBundle:SwiftMailer:email.html.twig', array('firstname' => $firstname,
															'lastname'  => $lastname,
															'email'     => $email,
															'object'    => $object,
															'message'   => $message)));

	        $this->get('mailer')->send($message);


		$this->addFlash('success','Ok');
		$this->addFlash('sent','Ok');
        					} else{$this->addFlash('error','Cant be reached like this');}
						} else if (($form->isValid() === FALSE ) && ($request->isMethod('POST'))) {
						      $this->addFlash('error','Cant be reached like this');
						      $this->addFlash('not_sent','Not Ok');}

        return $this->render('MainBundle:Default:contact.html.twig', array('form'    => $form->createView(),
                                                                          'firstname'  => $firstname,
									  'lastname'   => $lastname,
                                                                          'email'      => $email,
                                                                          'object'     => $object,
									  'message'    => $message));
    	}


    public function testAction(Request $request)
    {

	$name = $email = $objet = $regex = NULL;

	$validator = $this->get('validator');

	$form = $this->createFormBuilder()
         ->add('name')
	 ->add('email')
	 ->add('regex', TextType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
))
                                                                        ,new Length(array('min' => 3,
                                                                                          'max' => 10,
                                                                                          //'minMessage' => 'contact.error.lastnamemin',
                                                                                          //'maxMessage' => 'contact.error.lastnamemax' 
)))))

	 ->add('objet', ChoiceType::class, array('choices'  => array('' => null,'Yes' => "Yes",'No' => "No", 'Why Not' => "Why Not")))
         ->add('send', SubmitType::class , array('label' => 'Ok'))
         ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {


	if ($validator->validate($regex)) {

        $name = $form["name"]->getData();
	$email = $form["email"]->getData();
	$objet = $form["objet"]->getData();
	$regex = $form["regex"]->getData();


	}

        }


        return $this->render('MainBundle:Default:test.html.twig', array('form'  => $form->createView(),
									'name'  => $name,
									'email' => $email,
									'objet' => $objet,
									'regex' => $regex));
    }
}
