<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        ->add('email', EmailType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
))
									,new Assert\Email(array(//'message' => 'contact.error.email',
            											'checkMX' => true
)))))
/*
	->add('object', ChoiceType::class, array('choices' => array('' => '','Autre' => "Autre",'Bug' => "Bug", 'Demande' => "Demande"))
					 , array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.lastname'
)))))
*/
	->add('object', ChoiceType::class, array('choices' => array('' => '','Autre' => "Autre",'Bug' => "Bug", 'Demande' => "Demande")))
        ->add('message', TextareaType::class, array('constraints' => array(new NotBlank(array(//'message' => 'contact.error.messagenotblank'
))
								          ,new Length(array('min' => 8,
                                                                                            'max' => 10,
                                                                                           // 'minMessage' => 'contact.error.messagemin',
                                                                                           // 'maxMessage' => 'contact.error.messagemax' 
)))))

        ->add('send', SubmitType::class , array('label' => 'Envoyer'))
	->add('send2', SubmitType::class, array('attr' => array('id'   => 'autoclosable-btn-success')))
	->add('reset', ResetType::class , array('label' => 'Envoyer'))
        ->getForm();


	$form->handleRequest($request);

	if ($form->isValid()) {
        $firstname = $form["firstname"]->getData();
	$lastname = $form["lastname"]->getData();
        $email = $form["email"]->getData();
        $object = $form["object"]->getData();
	$message = $form["message"]->getData();

	if ($request->isMethod('POST')){
	$this->addFlash(
            'notice',
            'Ok');
	 $this->addFlash(
            'sent',
            'Ok');
        } else {
	$this->addFlash(
            'notice',
            'form can\'t be reached like this');
	}

	}

        return $this->render('MainBundle:Default:contact.html.twig', array('form'    => $form->createView(),
                                                                        'firstname'  => $firstname,
									'lastname'   => $lastname,
                                                                        'email'      => $email,
                                                                        'object'     => $object,
									'message'    => $message));
    }


    public function testAction(Request $request)
    {

	$name = $email = $objet =  NULL;

	$form = $this->createFormBuilder()
         ->add('name')
	 ->add('email')
	 ->add('objet', ChoiceType::class, array('choices'  => array('' => null,'Yes' => "Yes",'No' => "No", 'Why Not' => "Why Not")))
         ->add('send', SubmitType::class , array('label' => 'Ok'))
         ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
        $name = $form["name"]->getData();
	$email = $form["email"]->getData();
	$objet = $form["objet"]->getData();
        }


        return $this->render('MainBundle:Default:test.html.twig', array('form'  => $form->createView(),
									'name'  => $name,
									'email' => $email,
									'objet' => $objet));
    }
}
