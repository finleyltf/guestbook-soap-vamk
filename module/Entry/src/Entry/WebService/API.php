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
//        $entry = $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findBy(array('guest_name' => $guestName));
//        $phoneNumber = $entry->getPhoneNumber();
//        $imageName = $entry->getImage();

        $entry = $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findOneBy(array("guestName" => $guestName));
        $imageName = $entry->getImage();

        // get image content
        $imageURL = getcwd() . '/public/img/uploads/' . $imageName;
        $imageContent =  file_get_contents($imageURL);

        $imageData = base64_encode($imageContent);

        $entry->setImage($imageData);

        return $entry;
    }

    /**
     * Get all entries from the guestbook
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        return array(
            'entries' => $this->getEntityManager()->find('Entry\Entity\Entry', $id)
        );
    }


    /**
     * Get image of an entry
     * @param string $guestName
     * @return mixed
     */
    public function getImage($guestName)
    {


        $entry = $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findOneBy(array("guestName" => $guestName));
//        $phoneNumber = $entry->getPhoneNumber();
        $imageName = $entry->getImage();

//        echo '<pre>';
//        var_dump($imageName);
//        echo '</pre>';die;

        // get image content
        $imageURL = getcwd() . '/public/img/uploads/' . $imageName;
        $imageContent =  file_get_contents($imageURL);

        $imageData = base64_encode($imageContent);

        return $imageData;


    }

}