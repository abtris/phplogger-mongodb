<?php
/**
 * Created by PhpStorm.
 * User: prskavecl
 * Date: Aug 20, 2010
 * Time: 5:10:54 PM
 * To change this template use File | Settings | File Templates.
 */
/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php'; 
/**
 * ZendLogWriterCouchDb
 * @throws Zend_Log_Exception
 */
class App_Log_Writer_MongoDb extends Zend_Log_Writer_Abstract
{
    /**
     * Db
     * @var Mongo
     */
    private $_db;
    /**
     * Db name
     * @var string
     */
    private $_dbname;
    /**
     * Collection
     * @var string
     */
    private $_collection;
    /**
     *
     * @param array $params
     * @return void
     */
    public function __construct($options)
    {
        if (!extension_loaded('mongo')) {
            throw new Exception('The MongoDB extension must be loaded for using this logger !');
        }

        $options = $options->toArray();
        if (is_null($options)) {
            $options['host'] = "localhost";
            $options['port'] = "27017";
            $options['db'] = $dbname;
        }
        if (isset($options['user']) && isset($options['pass'])) {
            $conn = "{$options['user']}:{$options['pass']}@";
        } else {
            $conn = "";
        }
        $this->_db = new Mongo("mongodb://$conn{$options['host']}:{$options['port']}/{$options['db']}");
        $this->_dbname = $options['db'];
        $this->_collection = $options['collection'];
    }
    /**
     * @static
     * @param  $config
     * @return
     */
    static public function factory($config)                                                                                                                 
    {
        $config = self::_parseConfig($config);
        return $config;
    }
    /**
     * @param array $event
     * @return void
     */
    protected function _write($event)
    {
        $m = $this->_db;
        $m->connect();
        $c = $m->selectCollection($this->_dbname, $this->_collection);
        $c->insert($event);
    }

    
}