<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 21.11.2016
 * Time: 11:15
 */

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ClientBundle\Entity\ContactType;
use ClientBundle\Form\ContactTypeForm;

class ContactTypeController extends Controller
{
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $contactType = $em->getRepository('ClientBundle:ContactType')->find($id);
        if (!$contactType) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        }
        else
        {
            $form = $this->createForm(ContactTypeForm::class, $contactType);
            if ($this->isGranted('ROLE_ADMIN')) {
                $form->add('delete', SubmitType::class);
            }


            $form->handleRequest($request);

            if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid())
            {
                $contactType = $form->getData();
                if ($this->isGranted('ROLE_ADMIN') && $form->get('delete')->isClicked()) {
                    return $this->redirectToRoute('contacttype_del', array('id'=> $contactType->getId()));
                }
                $em->flush();
                return $this->redirectToRoute('contacttype_home');
            }


            return $this->render('ClientBundle:ContactType:edit.html.twig', array(
                'form' => $form->createView(), 'contactType' => $contactType));
        }
    }


    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contactType = $em->getRepository('ClientBundle:ContactType')->findAll();
        return $this->render('ClientBundle:ContactType:home.html.twig', array('contactTypes' => $contactType));
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $contactType = new ContactType();
        $form = $this->createForm(ContactTypeForm::class, $contactType);

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid())
        {
            $contactType = $form->getData();
            $em->persist($contactType);
            $em->flush();
            return $this->redirectToRoute('contacttype_home');
        }

        return $this->render('ClientBundle:ContactType:edit.html.twig', array('form' => $form->createView(),
            'contactType' => $contactType));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contactType = $em->getRepository('ClientBundle:ContactType')->find($id);
        if (!$contactType) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $contacts = $em->getRepository('ClientBundle:Contact')->findBy(array('type' => $id));
            foreach ( $contacts as $contact) {
               $client = $contact->getClient();
               $client->removeContact($contact);
               $em->remove($contact);
            }
            $em->remove($contactType);
            $em->flush();
        }
        return $this->redirectToRoute('contacttype_home');
    }
}

