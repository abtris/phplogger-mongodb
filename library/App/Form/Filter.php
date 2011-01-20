<?php
/**
 * Created by PhpStorm.
 * User: prskavecl
 * Date: Aug 23, 2010
 * Time: 8:58:18 AM
 * To change this template use File | Settings | File Templates.
 */
/**
 * Form Filter for Logger
 */
class App_Form_Filter extends Zend_Form
{
    /**
     * @var array of priorities where the keys are the
     * priority numbers and the values are the priority names
     */
    protected $_priorities = array();    
    /**
     * Init filter
     * @return void
     */
    public function init()
    {
       $logger = new Zend_Log();
       $r = new ReflectionClass($logger);
       $this->_priorities = array_flip($r->getConstants());        

        /* @var $this Zend_Form */
        $this->addElement('select','filter', array(
            'label'=> 'Priority',
            'multioptions' => array(null => 'All') + $this->_priorities,
        ));

       $this->addElement('text', 'datefrom', array(
            'label' => 'Date From'
       ));

       $this->addElement('text', 'dateto', array(
            'label' => 'Date To'
       ));

        $this->addElement('submit', 'send', array(

        ));
    }
}