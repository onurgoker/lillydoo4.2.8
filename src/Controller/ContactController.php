<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Contact;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contacts")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $contactsRepository = $em->getRepository(Contact::class);
        $allContactsQuery = $contactsRepository->createQueryBuilder('p')->getQuery();            
        $paginator  = $this->get('knp_paginator');
        $contacts = $paginator->paginate($allContactsQuery,$request->query->getInt('page', 1), 5);

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'controller_name' => 'ContactController',
        ]);
    }

    /**
    * @Route("/contact/{id}", name="contact")
    */
    public function show(Contact $contact)
    {
        //$deleteForm = $this->createDeleteForm($post);

        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contact->getId());

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
            //'delete_form' => $deleteForm->createView(),
        ]);
    }

    public function new() 
    {
        die("fdsf");
        /*
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        $contact->setFirstname('Onur');
        $contact->setLastname('Göker');
        $contact->setAddress('Eskisehir Yolu, Etimesgut');
        $contact->setZip('06800');
        $contact->setCityId(6);
        $contact->setCountryId(90);
        $contact->setPhonenumber(532553435);
        $contact->setBirthday('14 Apr 1989');
        $contact->setEmail('info@onurgoker.com');

        // tell Doctrine you want to (eventually) save the Contact (no queries yet)
        $entityManager->persist($contact);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new contact with id '.$contact->getId());
        */

        $form = $this->createFormBuilder($task, [
                'method' => 'POST',
                'action' => '/contact/create'
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'First Name'
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Last Name'
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'label' => 'Address'
            ])            
            ->add('phonenumber', IntegerType::class, [
                'required' => true,
                'label' => 'Phone Number'
            ])                
            ->add('zip', IntegerType::class, [
                'required' => true,
                'label' => 'Zip'
            ])                
            ->add('birthday', TextType::class, [
                'required' => true,
                'label' => 'Birthday'
            ])                
            ->add('email', TextType::class, [
                'required' => true,
                'label' => 'Email'
            ])                
            ->add('picture', TextType::class, [
                'required' => false,
                'label' => 'Photo'
            ])                
            ->getForm();

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete()
    {

    }
}
