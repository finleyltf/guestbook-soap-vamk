<?php

namespace Entry\WebService;

use Entry\Entity\Entry;
use Doctrine\ORM\EntityManager;

class API
{
    public $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    protected $em;
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    /**
     * Get all entries from the guestbook
     * @return array
     */
    public function getAll()
    {
        return array(
            'entries' => $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findall()
        );
    }


    /**
     * Get a single entry by name
     * @param string $guestName
     * @return mixed
     */
    public function getEntryByName($guestName)
    {
//        $entry = $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findBy(array('guestName' => $guestName));
        $entry = 'the guestName is: ' . $guestName ;
        return $entry;
    }


    /**
     * Add an entry
     * @param string $guestName
     * @param string $phoneNumber
     * @param string $image
     */

}