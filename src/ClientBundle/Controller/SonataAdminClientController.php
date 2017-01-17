<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 01.12.2016
 * Time: 13:14
 */

namespace ClientBundle\Controller;

use Assetic\Filter\PackerFilter;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SonataAdminClientController extends CRUDController
{
    private function updateContacts(Request $request, $object)
    {
        $arr1 = array();
        //шматок гавнокода
        $postData = $request->request->all();
        foreach ($postData as $arr) {
            $arr1 = $arr;
            break;
        }
        $tmptest = '';


        if ($postData) {
            $old_contacts = null;
            $new_contacts = null;
            $old_contacts = $object->getContacts();
            $em = $this->getDoctrine()->getManager();
            if (array_key_exists("contacts", $arr1)) {
                $new_contacts = $arr1["contacts"];

                // Викидуем з массива нових контактів, які прийшли з POST, ті що вже були
                // і видаляем з бази контакти які видалені у клієнта
                foreach ($old_contacts as $contact) {
                    $k = array_search($contact->getId(), $new_contacts);
                    if ($k === false) {
                        $object->removeContact($contact);
                        $em->remove($contact);
                    } else {
                        unset($new_contacts[$k]);
                    }
                }

                foreach ($new_contacts as $contact_id) {
                    $contact = $em->getRepository('ClientBundle:Contact')->find($contact_id);
                    if (!$contact) {
                        throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $contact_id));
                    } else {
                        $object->addContact($contact);
                        $contact->setClient($object);
                    }
                }
            } else {
                // Post прийшов без контактів - видаляем всі контакти клієнта
                foreach ($old_contacts as $contact) {
                    $object->removeContact($contact);
                    $em->remove($contact);
                }
            }
        }

        if ($tmptest == '') {
            return null;
        } else {
            return new Response($tmptest);
        }
    }


    public function preCreate(Request $request, $object)
    {
        parent::preCreate($request, $object);
      //  $dt = date_create();
      //  $dt->format('Y-m-d');
      //  $object->setCreatedAt($dt);
        return $this->updateContacts($request, $object);
    }

    public function preEdit( Request $request, $object)
    {
        parent::preEdit($request, $object);
        return $this->updateContacts($request, $object);
    }

    public function preDelete(Request $request, $object)
    {
        parent::preDelete($request, $object);
        /*
        $em = $this->getDoctrine()->getManager();

        $contacts = $object->getContacts();
        foreach ($contacts as $contact) {
            $object->removeContact($contact);
            $em->remove($contact);
        }
        */
        //$em->flush();
        return null;
    }
}