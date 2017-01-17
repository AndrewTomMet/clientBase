<?php


namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ClientBundle\Entity\Lang;
use ClientBundle\Entity\Client;
use ClientBundle\Form\LangForm;

class LangController extends Controller
{
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lang = $em->getRepository('ClientBundle:Lang')->find($id);
        if (!$lang) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        } else {
            $form = $this->createForm(LangForm::class, $lang);
            if ($this->isGranted('ROLE_ADMIN')) {
                $form->add('delete', SubmitType::class);
            }

            $form->handleRequest($request);

            if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
                $lang = $form->getData();
                if ($this->isGranted('ROLE_ADMIN') && $form->get('delete')->isClicked()) {
                    return $this->redirectToRoute('lang_del', array('id'=> $lang->getId()));
                }
                //$em->persist($lang);
                $em->flush();
                return $this->redirectToRoute('lang_home');
            }

            return $this->render('ClientBundle:Lang:edit.html.twig', array(
                'form' => $form->createView(), 'lang' => $lang));
        }
    }


    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $langs = $em->getRepository('ClientBundle:Lang')->findAll();
        return $this->render('ClientBundle:Lang:home.html.twig', array('langs' => $langs));
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lang = new Lang();
        $form = $this->createForm(LangForm::class, $lang);

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $lang = $form->getData();
            var_dump($lang);
            $em->persist($lang);
            $em->flush();
            return $this->redirectToRoute('lang_home');
        }

        return $this->render('ClientBundle:Lang:edit.html.twig', array('form' => $form->createView(),
            'lang' => $lang));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lang = $em->getRepository('ClientBundle:Lang')->find($id);
        if (!$lang) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        } else {
            $em = $this->getDoctrine()->getManager();
            $clients = $em->getRepository('ClientBundle:Client')->findBy(array('language' => $id));
            foreach ( $clients as $client) {
                $client->setLanguage();
            }
            $em->remove($lang);
            $em->flush();
        }
        return $this->redirectToRoute('lang_home');
    }
}