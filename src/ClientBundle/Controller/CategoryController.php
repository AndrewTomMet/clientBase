<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Category;
use ClientBundle\Form\CategoryForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ClientBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        }

        $form = $this->createForm(CategoryForm::class, $category);
        if ($this->isGranted('ROLE_ADMIN')) {
            $form->add('delete', SubmitType::class);
        }

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            if ($this->isGranted('ROLE_ADMIN') && $form->get('delete')->isClicked()) {
                return $this->redirectToRoute('category_del', array('id'=> $category->getId()));
            }
            //$em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_home');
        }


        return $this->render('ClientBundle:Category:edit.html.twig', array(
            'form' => $form->createView(), 'category' => $category));

    }


    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ClientBundle:Category')->findAll();
        return $this->render('ClientBundle:Category:home.html.twig', array('categories' => $categories));
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_home');
        }
        return $this->render('ClientBundle:Category:edit.html.twig', array('form' => $form->createView(),
            'category' => $category));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ClientBundle:Category')->find($id);
        if (!$category) {
            throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $id));
        } else {
            $em->remove($category);
            $em->flush();
        }
        return $this->redirectToRoute('category_home');
    }

}
//php bin/console doctrine:database:create
//php bin/console doctrine:schema:update --force