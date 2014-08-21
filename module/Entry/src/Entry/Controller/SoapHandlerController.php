<?php

namespace Entry\Controller;


use Entry\WebService\API;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Client;
use Zend\Soap\Server;
use Zend\View\Model\ViewModel;

class SoapHandlerController extends AbstractActionController
{

    private $_URI;
    private $_WSDL_URI;

    public function indexAction()
    {
        $sm = $this->getServiceLocator();

        $this->_URI      = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/soaphandler";
        $this->_WSDL_URI = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/soaphandler?wsdl";

        if (isset($_GET['wsdl'])) {
            $this->handleWSDL($sm);
        } else {
            $this->handleSOAP($sm);
        }

        // this is required to strip out the layout, otherwise not nice results!
        $result = new ViewModel();
        $result->setTerminal(true);

        return $result;
    }


    public function handleWSDL($sm)
    {
        $autodiscover = new AutoDiscover();
        $autodiscover->setClass(new API($sm))
            ->setUri($this->_URI);
        $wsdl = $autodiscover->generate();
        // handle request
        $autodiscover->handle();
    }


    public function handleSOAP($sm)
    {
        $soap = new Server(NULL, array('wsdl' => $this->_WSDL_URI));
        $soap->setWSDLCache(false);
        $soap->setClass(new API($sm));
        $soap->handle();
    }


    public function clientAction()
    {
        $options = array(
            'location' => 'http://guestbook-soap-vamk.local/soaphandler',
            'uri'      => 'http://guestbook-soap-vamk.local/soaphandler',
            'cache_wsdl' => WSDL_CACHE_NONE,
        );

        $client = new Client(null, $options);

//        $client = new Client('http://guestbook-soap.local/handler');


//        $result = $client->getAll();
        $result = $client->getEntryByName("Mike Nick");


        echo '<pre>';
        var_dump($result);
        echo '</pre>';die;

    }


}