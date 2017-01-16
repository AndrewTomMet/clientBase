<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 21.11.2016
 * Time: 10:52
 */

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ClientBundle\Form\ClientForm;
use ClientBundle\Form\CategoriesForm;
use ClientBundle\Entity\Client;
use ClientBundle\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ClientController extends Controller
{
    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id, Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $client = $em->find('ClientBundle:Client', $id);

        if (!$client) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        }
        else
        {
            $form = $this->createForm(ClientForm::class, $client, array('id' => $client->getId()));
            // перенести в вьюв
            if ($this->isGranted('ROLE_ADMIN')) {
                $form->add('delete', SubmitType::class);
            }

            $form->handleRequest($request);

            if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid())
            {
                $client = $form->getData();

                if ($this->isGranted('ROLE_ADMIN') && $form->get('delete')->isClicked()) {
                    return $this->redirectToRoute('client_del', array('id'=> $client->getId()));
                }
                else if ($form->get('addcontact')->isClicked())
                {
                    $contact = new Contact();
                    $clientform = $request->request->get('client_form');


                    $contactType = $em->find('ClientBundle:ContactType', $clientform['newtypecontact']);
                    if (!$contactType) {
                        throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $clientform['newtypecontact']));
                    } else {

                        $contact->setType($contactType);
                        $contact->setMean($clientform['newmeancontact']);
                        $client->addContact($contact);
                        $em->persist($contact);
                        $em->flush();
                    }
                } else {

                    $em->flush();
                    return $this->redirectToRoute('client_home');
                }
            }


            return $this->render('ClientBundle:Default:edit.html.twig',
                                 array( 'form' => $form->createView(), 'client' => $client));
        }
    }

    public function searchAction(Request $request)
    {
        $searcher =  $this->get('searcher');

        $result = $searcher->search($request->request->get('serchtags'));
        $em = $this->getDoctrine()->getRepository('ClientBundle:Client');

        //$clients

        //SeacherForm

        return $this->render('ClientBundle:Default:home.html.twig');
    }

    public function homeAction(Request $request, $ctg = '')
    {
        $ctg_request = $request->request->get('categories_form');
        if ($ctg_request != null && $ctg_request['categories'] != '') {
            $ctg = (integer) $ctg_request['categories'];
        }
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ClientBundle:Category')->findAll();
        $form = $this->createForm(CategoriesForm::class, $categories);
        $form->handleRequest($request);
        if (is_integer($ctg)) {
            $category = $em->getRepository('ClientBundle:Category')->find($ctg);
            $clients =  $category->getClients();
            return $this->render('ClientBundle:Default:home.html.twig', array('form' => $form->createView(),
                                                                              'clients' => $clients));
        } else {
            $clients = $em->getRepository('ClientBundle:Client')->findAll();
            return $this->render('ClientBundle:Default:home.html.twig', array('form' => $form->createView(),
                                                                              'clients' => $clients));
        }

    }


    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        $form = $this->createForm(ClientForm::class, $client, array('id' => $client->getId()));

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            if ($form->get('addcontact')->isClicked()) {
                $contact = new Contact();
                $clientform = $request->request->get('client_form');

                $contactType = $em->getRepository('ClientBundle:ContactType')->find($clientform['newtypecontact']);
                if (!$contactType) {
                    throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $clientform['newtypecontact']));
                } else {

                    $contact->setType($contactType);
                    $contact->setMean($clientform['newmeancontact']);
                    $client->addContact($contact);
                    //$contact->setClient($client);
                    $em->persist($contact);
                    $em->persist($client);
                    $em->flush();
                    return $this->redirectToRoute('client_show',array('id'=>$client->getId()));
                }
            }

            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client_home');

        }

        return $this->render('ClientBundle:Default:edit.html.twig', array('form' => $form->createView(),
            'client' => $client));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('ClientBundle:Client')->find($id);
        if (!$client) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        } else {
            $em->remove($client);
            $em->flush();
        }
        return $this->redirectToRoute('client_home');
    }
}