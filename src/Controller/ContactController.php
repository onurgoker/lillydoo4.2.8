<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contacts")
     */
    public function index()
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAll();

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

    public function create() 
    {
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
    }
}
