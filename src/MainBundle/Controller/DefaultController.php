<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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



    public function sendFileAction($file){

    $file_to_send = "Resources/public/files/Symfony_book_3.0.pdf";
    $response = new BinaryFileResponse($file_to_send);
    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,".$file");
    return $response;
    }

    public function serviceAction()
    {
        return $this->render('MainBundle:Default:service.html.twig', array('filename' => "Symfony_book_3.0"));
    }

    public function indexAction()
    {

	$rand1 = random_bytes(10);
        $random = bin2hex($rand1);
	$rand = base64_encode($rand1);
	$randomnum1 = random_int(1, 9);
	$randomnum2 = random_int(1, 9);
	$randomnum3 = random_int(1, 9);
	$randomnum4 = random_int(1, 9);
	$randomnum5 = random_int(1, 9);
	$randomnum6 = random_int(1, 9);

	$randomf = rand(0, 1000) / 1000;

	$randmt1 = mt_rand(1, 100);
	$randmt2 = mt_rand();
	$randlet = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 25)), 0, 10);
	$randate= mt_rand(1161055381,1462055981);
	$randwords = array("sportive"=>"a","spontanée"=>"b","douce"=>"c","simple"=>"d","authentique"=>"e","éthique"=>"f","intelligente"=>"g","cultivée"=>"h",
			   "sexy"=>"i","studieuse"=>"j","attentionnée"=>"k","énergique"=>"l");
	$randw = (array_rand($randwords, 2));

	$elle = 0;
	$valid = 0;

	$size = 0;
	$randsize = mt_rand(50, 85) + 100;
	$size = $randsize;

	if($size >= "155" && $size <= "175"){$elle = $elle + 1;}

	$c=array("Bleu"=>"a","Vert"=>"b","Marron" =>"c");
	$randeyes = (array_rand($c,1));

	if($randeyes == "Bleu" OR $randeyes == "Vert"){$elle = $elle + 1;}

	$h=array("Noir"=>"a","Brune"=>"b","Chatain"=>"c","Blonde"=>"d","Rousse"=>"e");
	$randhair = (array_rand($h, 1));

	if($randhair == "Brune" OR $randhair == "Rousse" OR $randhair == "Chatain"){$elle = $elle + 1;}
	if($randhair == "Blonde"){$elle = $elle + 2;}


	$q=array("sportive"=>"a","spontanée"=>"b","douce"=>"c","simple"=>"d","authentique"=>"e","éthique"=>"f","intelligente"=>"g","cultivée"=>"h");
        $randqual = (array_rand($q, 3));

	if(in_array("sportive", $randqual)) {$elle = $elle + 1;}
	if(in_array("spontanée", $randqual)) {$elle = $elle + 1;}

	if($elle >= "3"){$valid = 1;}
        return $this->render('MainBundle:Default:index.html.twig', array('randsize' => $randsize, 'elle' => $elle, 'randeyes' => $randeyes, 'randhair' => $randhair,
									 'valid' => $valid, 'randqual' => $randqual,
									 'random'  => $random, 'rand' => $rand, 'randomnum1' => $randomnum1,
													        'randomnum2' => $randomnum2,
                                                                                                                'randomnum3' => $randomnum3,
                                                                                                                'randomnum4' => $randomnum4,
                                                                                                                'randomnum5' => $randomnum5,
                                                                                                                'randomnum6' => $randomnum6,
									 'randomf' => $randomf, 'randmt1' => $randmt1, 'randmt2' => $randmt2, 'randlet' => $randlet,
									 'randate' => $randate, 'randw' => $randw));
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
