<?php

require('lib\fpdm\fpdm.php');

define('USERS_JSON', 'input/users.json');
define('TEMPLATE_PDF', 'input/alfa.pdf');

class NewFpdm {  

    private static $instance; 
    private static $fpdm;
    private static $template_pdf = TEMPLATE_PDF;
    private static $users;

    private function __construct($t_pdf) {
        if(file_exists(self::$template_pdf)){
            self::$fpdm = new FPDM($t_pdf);            
        } else {
            echo "File ".self::$template_pdf." is not exits.";
            exit;      
        }
    }
    
    public static function getInstance() {
        if (self::$instance==null) {
            self::$instance = new NewFpdm(self::$template_pdf);
        }
        return self::$instance;
    }

    public function getFpdm() {
        return self::$fpdm;
    }

    public function getFields() {
            $fields = [];
            self::$users = file(USERS_JSON, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if(is_array(self::$users)){
                foreach(self::$users as $user) {
                    foreach (json_decode($user) as $key => $value) {
                        if ($key === 'name') {
                            $fields['Text104'] = $value;
                        } elseif($key === 'last_name') {
                            $fields['Text103'] = $value;
                        } elseif($key === 'dob') {
                            $val = explode('-', $value);
                            $fields['Text108'] = $val[0];
                            $fields['Text107'] = $val[1];
                            $fields['Text106'] = $val[2];
                        }
                    }
                }
                return $fields;
            } else {
                echo "Failed with json data.";
                return exit;
            }
    }

    private function __clone(){}
    private function __wakeup(){}
}
