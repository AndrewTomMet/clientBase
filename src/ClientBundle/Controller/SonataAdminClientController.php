<?php

namespace ClientBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SonataAdminClientController
 */
class SonataAdminClientController extends CRUDController
{
    /**
     * @param Request $request
     * @param mixed   $object
     * @return null|Response
     */
    protected function preCreate(Request $request, $object)
    {
        parent::preCreate($request, $object);

        return $this->updateContacts($request, $object);
    }

    /**
     * @param Request $request
     * @param mixed   $object
     * @return null|Response
     */
    protected function preEdit(Request $request, $object)
    {
        parent::preEdit($request, $object);

        return $this->updateContacts($request, $object);
    }

    private function updateContacts(Request $request, $object)
    {
        $arr1 = [];
        //шматок гавнокода
        $postData = $request->request->all();
        foreach ($postData as $arr) {
            $arr1 = $arr;
            break;
        }
        $tmpTest = '';

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

        if ('' === $tmpTest) {
            return null;
        } else {
            return new Response($tmpTest);
        }
    }
}
