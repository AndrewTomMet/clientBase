<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ClientBundle\Form\Type\ClientForm;
use ClientBundle\Form\Type\CategoriesForm;
use ClientBundle\Entity\Client;
use ClientBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClientController
 */
class ClientController extends Controller
{
    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkAction($id)
    {
        $validator = $this->get('client.contains_checkhaveallcontacttypes_validator');
        $em = $this->getDoctrine()->getManager();
        $client = $em->find('ClientBundle:Client', $id);
        $allContactTypes = $em->getRepository('ClientBundle:ContactType')->findAll();
        $validator->setContactTypes($allContactTypes);

        $errors = $validator->validate($client);

        return new Response('test '.$id);
    }

    /**
     * @param int     $id
     * @param Request $request
     * @Method({"GET", "POST"})
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
        } else {
            $form = $this->createForm(ClientForm::class, $client, array('id' => $client->getId()));
            // перенести в вьюв
            if ($this->isGranted('ROLE_ADMIN')) {
                $form->add('delete', SubmitType::class);
            }

            $form->handleRequest($request);

            if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
                $client = $form->getData();

                if ($this->isGranted('ROLE_ADMIN') && $form->get('delete')->isClicked()) {
                    return $this->redirectToRoute('client_del', array('id' => $client->getId()));
                } elseif ($form->get('addcontact')->isClicked()) {
                    $contact = new Contact();
                    $clientForm = $request->request->get('client_form');

                    $contactType = $em->find('ClientBundle:ContactType', $clientForm['newtypecontact']);
                    if (!$contactType) {
                        throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $clientForm['newtypecontact']));
                    } else {
                        $contact->setType($contactType);
                        $contact->setMean($clientForm['newmeancontact']);
                        $client->addContact($contact);
                        $em->persist($contact);
                        $em->flush();
                    }
                } else {
                    $em->flush();

                    return $this->redirectToRoute('client_home');
                }
            }

            return $this->render('ClientBundle:Default:edit.html.twig', ['form' => $form->createView(), 'client' => $client]);
        }
    }

    /**
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction()
    {
         return $this->render('ClientBundle:Default:home.html.twig');
    }

    /**
     * @param Request $request
     * @param string  $ctg
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request, $ctg = '')
    {
        $ctgRequest = $request->request->get('categories_form');
        if (null !== $ctgRequest && '' !== $ctgRequest['categories']) {
            $ctg = (int) $ctgRequest['categories'];
        }
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ClientBundle:Category')->findAll();
        $form = $this->createForm(CategoriesForm::class, $categories);
        $form->handleRequest($request);
        if (is_integer($ctg)) {
            $category = $em->getRepository('ClientBundle:Category')->find($ctg);
            $clients =  $category->getClients();

            return $this->render('ClientBundle:Default:home.html.twig', ['form' => $form->createView(), 'clients' => $clients]);
        } else {
            $clients = $em->getRepository('ClientBundle:Client')->findAll();

            return $this->render('ClientBundle:Default:home.html.twig', ['form' => $form->createView(), 'clients' => $clients]);
        }
    }

    /**
     * @param Request $request
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
                $clientForm = $request->request->get('client_form');

                $contactType = $em->getRepository('ClientBundle:ContactType')->find($clientForm['newtypecontact']);
                if (!$contactType) {
                    throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $clientForm['newtypecontact']));
                } else {
                    $contact->setType($contactType);
                    $contact->setMean($clientForm['newmeancontact']);
                    $client->addContact($contact);
                    $em->persist($contact);
                    $em->persist($client);
                    $em->flush();

                    return $this->redirectToRoute('client_show', ['id' => $client->getId()]);
                }
            }
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_home');
        }

        return $this->render('ClientBundle:Default:edit.html.twig', ['form' => $form->createView(), 'client' => $client]);
    }

    /**
     * @param int $id
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
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
