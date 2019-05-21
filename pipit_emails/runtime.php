<?php

    spl_autoload_register(function($class_name){
        if (strpos($class_name, 'PipitEmails_')===0) {
            include(PERCH_PATH.'/addons/apps/pipit_emails/lib/'.$class_name.'.class.php');
            return true;
        }
        return false;
    });
    
    include(__DIR__.'/events.php');