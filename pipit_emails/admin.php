<?php
    include(__DIR__.'/_version.php');
    $this->register_app('pipit_emails', 'Emails', 5, 'Emails app', PIPIT_EMAILS_VERSION);
    $this->require_version('pipit_emails', '3.0');
    
    
    spl_autoload_register(function($class_name){
        if (strpos($class_name, 'PipitEmails_')===0) {
            include(PERCH_PATH.'/addons/apps/pipit_emails/lib/'.$class_name.'.class.php');
            return true;
        }
        return false;
    });
    
    include(__DIR__.'/events.php');
    include(__DIR__.'/fieldtypes.php');
    