<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Entry\Controller;

use Entry\Entity\Entry;

use Zend\Db\Sql\Ddl\Column\Text;
use Zend\Filter\Int;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Request;
use Zend\View\Model\ViewModel;

use Doctrine\ORM\EntityManager;
use Zend\Filter\FilterChain;
use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http as FileTransferAdapter;

class EntryController extends AbstractActionController
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }

        return $this->em;
    }

    public function indexAction()
    {

        return new ViewModel(array(
            'entries' => $this->getEntityManager()->getRepository('Entry\Entity\Entry')->findall()
        ));

    }


}
