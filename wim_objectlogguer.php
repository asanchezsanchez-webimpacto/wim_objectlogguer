<?php
if(!defined('_PS_VERSION_'))
    exit;

class Wim_objectlogguer extends Module {
    public function __construct() {
        $this->name = 'wim_objectlogguer';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'alvaro sanchez';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();
    }

    public function install() {
        Db::getInstance()->execute(
            "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."objectlogguer`(
                `id_objectlogguer` int(11) AUTO_INCREMENT,
                `affected_object` int(11),
                `action_type` varchar(255),
                `object_type` varchar(255),
                `message` text,
                `date_add` datetime,
                PRIMARY KEY (`id_objectlogguer`)
            ) ENGINE="._MYSQL_ENGINE_."DEFAULT CHARSET=UTF8;"
        );

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('actionObjectAddBefore') &&
            $this->registerHook('actionObjectAddAfter') &&
            $this->registerHook('actionObjectUpdateBefore') &&
            $this->registerHook('actionObjectUpdateAfter') &&
            $this->registerHook('actionObjectDeleteBefore') &&
            $this->registerHook('actionObjectDeleteAfter');
    }


    /*function hookActionObjectDeleteBefore($params){
        Db::getInstance()->insert('objectlogguer',array(
            'affected_object' => $params['object']->id,
            'action_type' => 'delete',
            'object_type' => get_class($params['object']),
            'message' => 'deleteado correctamente',
            'date_add' =>date("Y-m-d H:i:s")
        ));
    }*/

    function hookActionObjectDeleteAfter($params){
        Db::getInstance()->insert('objectlogguer',array(
            'affected_object' => $params['object']->id,
            'action_type' => 'delete',
            'object_type' => get_class($params['object']),
            'message' => 'deleteado correctamente',
            'date_add' =>date("Y-m-d H:i:s")
        ));
    }
/************************************************** */
    /*function hookActionObjectAddBefore($params){

    }*/

    function hookActionObjectAddAfter($params){
        DB::getInstance()->insert('objectlogguer',array(
            'affected_object' => $params['object']->id,
            'action_type' => 'add',
            'object_type' => get_class($params['object']),
            'message' => 'añadido correctamente',
            'date_add' =>date("Y-m-d H:i:s")
        ));
    }
/*********************************************************** */


    /*function hookActionObjectUpdateBefore($params){
        Db::getInstance()->insert('objectlogguer',array(
            'affected_object' => $params['object']->id,
            'action_type' => 'update',
            'object_type' => get_class($params['object']),
            'message' => 'actualizado correctamente',
            'date_add' =>date("Y-m-d H:i:s")
        ));
    }*/

    function hookActionObjectUpdateAfter($params){
        Db::getInstance()->insert('objectlogguer',array(
            'affected_object' => $params['object']->id,
            'action_type' => 'add',
            'object_type' => get_class($params['object']),
            'message' => 'añadido correctamente',
            'date_add' =>date("Y-m-d H:i:s")
        ));
    }


} 