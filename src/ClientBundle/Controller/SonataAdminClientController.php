<?php

namespace ClientBundle\Controller;

use Assetic\Filter\PackerFilter;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SonataAdminClientController
 */
class SonataAdminClientController extends CRUDController
{
    private function updateContacts(Request $request, $object)
    {
        $arr1 = [];
        //шматок гавнокода
        $postData = $request->request->all();
        foreach ($postData as $arr) {
            $arr1 = $arr;
            break;
        }
        $tmptest = '';

        if ($postData) {
            $oldContacts = null;
            $newContacts = null;
            $oldContacts = $object->getContacts();
            $em = $this->getDoctrine()->getManager();
            if (array_key_exists('contacts', $arr1)) {
                $newContacts = $arr1['contacts'];

                // Викидуем з массива нових контактів, які прийшли з POST, ті що вже були
                // і видаляем з бази контакти які видалені у клієнта
                foreach ($oldContacts as $contact) {
                    $k = array_search($contact->getId(), $newContacts);
                    if (false === $k) {
                        $object->removeContact($contact);
                        $em->remove($contact);
                    } else {
                        unset($newContacts[$k]);
                    }
                }

                foreach ($newContacts as $contactId) {
                    $contact = $em->getRepository('ClientBundle:Contact')->find($contactId);
                    if (!$contact) {
                        throw $this->createNotFoundException(sprintf('не знайдений об\'єкт з id : %s', $contactId));
                    } else {
                        $object->addContact($contact);
                        $contact->setClient($object);
                    }
                }
            } else {
                // Post прийшов без контактів - видаляем всі контакти клієнта
                foreach ($oldContacts as $contact) {
                    $object->removeContact($contact);
                    $em->remove($contact);
                }
            }
        }

        if ('' === $tmptest) {
            return null;
        } else {
            return new Response($tmptest);
        }
    }

    /**
     * @param Request $request
     * @param mixed   $object
     * @return null|Response
     */
    public function preCreate(Request $request, $object)
    {
        parent::preCreate($request, $object);

        return $this->updateContacts($request, $object);
    }

    /**
     * @param Request $request
     * @param mixed   $object
     * @return null|Response
     */
    public function preEdit(Request $request, $object)
    {
        parent::preEdit($request, $object);

        return $this->updateContacts($request, $object);
    }

    /**
     * @param Request $request
     * @param mixed   $object
     * @return null
     */
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
