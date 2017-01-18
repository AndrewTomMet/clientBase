<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ClientBundle\Entity\Lang;
use ClientBundle\Form\LangForm;

/**
 * Class LangController
 */
class LangController extends Controller
{
    /**
     * @param int     $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
                    return $this->redirectToRoute('lang_del', array('id' => $lang->getId()));
                }
                $em->flush();

                return $this->redirectToRoute('lang_home');
            }

            return $this->render('ClientBundle:Lang:edit.html.twig', ['form' => $form->createView(), 'lang' => $lang]);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $langs = $em->getRepository('ClientBundle:Lang')->findAll();

        return $this->render('ClientBundle:Lang:home.html.twig', ['langs' => $langs]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lang = new Lang();
        $form = $this->createForm(LangForm::class, $lang);

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $lang = $form->getData();
            $em->persist($lang);
            $em->flush();

            return $this->redirectToRoute('lang_home');
        }

        return $this->render('ClientBundle:Lang:edit.html.twig', ['form' => $form->createView(), 'lang' => $lang]);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $lang = $em->getRepository('ClientBundle:Lang')->find($id);
        if (!$lang) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        } else {
            $em = $this->getDoctrine()->getManager();
            $clients = $em->getRepository('ClientBundle:Client')->findBy(array('language' => $id));
            foreach ($clients as $client) {
                $client->setLanguage();
            }
            $em->remove($lang);
            $em->flush();
        }

        return $this->redirectToRoute('lang_home');
    }
}
