<?php

class IndexController extends Zend_Controller_Action
{
    protected $_config;

    public function preDispatch()  
    {
            $this->_config = new Zend_Config_Ini('../application/configs/'.
                    'application.ini', APPLICATION_ENV);
    }

    public function indexAction()
    {

//         $this->view->docs = $result->toArray();
//         $this->view->messages = $this->_helper->flashMessenger->getMessages();

         $logger = new Zend_Log();
         $r = new ReflectionClass($logger);
         $this->view->priorities = array_flip($r->getConstants());

    }

    public function logAction()
    {
          $id = $this->_request->getParam('id', 0);  

          $logger = new Zend_Log();
          $format = '%timestamp% %priorityName% (%priority%): '.
            '[%module%] [%controller%] %message%';                                                                                                
          $formatter = new Zend_Log_Formatter_Simple($format);
          
          $writer = new App_Log_Writer_MongoDb($this->_config->mongodb);
          $writer->setFormatter($formatter);

          $logger->addWriter($writer);
          $logger->setEventItem('module', $this->getRequest()->getModuleName());
          $logger->setEventItem('controller', $this->getRequest()->getControllerName());                        
          $logger->log("Testovani chyba", $id);
          $this->_helper->flashMessenger->addMessage('Log item saved');
          $this->_helper->redirector('index');
    }


}

