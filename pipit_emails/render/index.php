<?php
    # include the API and classes
    include(__DIR__.'/../../../../core/inc/api.php');
    
    $classes = [
        '../lib/PipitEmails_Emails.class.php',
        '../lib/PipitEmails_Email.class.php',
    ];
	
	if($classes) {
        foreach($classes as $class)	{ include($class); }
    }

	$API  = new PerchAPI(1.0, 'pipit_emails');
	$Lang = $API->get('Lang');
	$HTML = $API->get('HTML');
    $Template = $API->get('Template');
    $Emails = new PipitEmails_Emails($API);
    $Email = false;
    

    if (PerchUtil::get('id')) {
        $emailID   = (int) $_GET['id'];
        $Email     = $Emails->find($emailID);
        if (is_object($Email)) {
            $details  = $Email->to_array();
        } else {
            PerchUtil::redirect($API->app_path() . '/edit');
        }

    } else {
        if (!$CurrentUser->has_priv('pipit_emails.email.create')) {
		    PerchUtil::redirect($API->app_path());
        }
    }


    if ($Email && $Email->template() != '') {
        $template_status = $Template->set('emails/'.$Email->template(), 'email');
        if($template_status > 400) {
            $Template->set('emails/default.html', 'email');
            $message = $HTML->failure_message('Template ' . $Email->template() . ' could not be found.');
        }
	} else {
        $Template->set('emails/default.html', 'email');
    }

    //echo '<pre>' . print_r($Template, 1) . '</pre>';
    //echo '<pre>' . print_r($details, 1) . '</pre>';
    echo $Template->render($details);