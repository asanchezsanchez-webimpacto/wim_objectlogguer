<?php

require_once 'classes/ObjectLogguer.php';

if(!defined('_PS_VERSION_'))
    exit;

class Wim_objectlogguer extends Module {
    public function __construct() {
        $this->name = 'wim_objectlogguer';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'alvaro_sanchez';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        $this->displayName = 'modulo log';
        $this->description = 'modulo wim_objectlogguer';
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
            $this->registerHook('actionObjectAddAfter') &&
            $this->registerHook('actionObjectUpdateAfter') &&
            $this->registerHook('actionObjectDeleteAfter');
    }



    
    
    public function insertarCampo($params, $event){
        $after = new ObjectLogguer();
            $after->affected_object = $params['object']->id;
            $after->action_type = $event;
            $after->object_type = get_class($params['object']);
            $after->message = "Object ". get_class($params['object']) . " with id " . $params['object']->id;
            $after->date_add = date("Y-m-d H:i:s");

            if(get_class($params['object']) != 'ObjectLogguer') {
                $after->add();
            }
    }

    public function hookActionObjectAddAfter($params){
        $this->insertarCampo($params, 'Add');
    }

    public function hookActionObjectUpdateAfter($params)
    {
        $this->insertarCampo($params, 'Update');
    }


    public function hookActionObjectDeleteAfter($params)
    {
        $this->insertarCampo($params, 'Delete');
    }
} 

?>