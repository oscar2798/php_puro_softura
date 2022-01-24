<?php

class ConfigBD{

    public static function getConfig(){
        switch ($_SERVER['SERVER_NAME']){
            case 'host_pruebas.com':
                break;
            default:
                $dbConfig = array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => '',
                    'database' => 'cap_softura_php'
                );
                break;
        }
        return $dbConfig;
    }

}