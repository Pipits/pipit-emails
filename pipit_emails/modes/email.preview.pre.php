<?php
    $Emails = new PipitEmails_Emails($API);
    $Email = false;
    $message = '';
    $details = array();

    if (PerchUtil::get('id')) {
        if (!$CurrentUser->has_priv('pipit_emails.email.edit')) {
		    PerchUtil::redirect($API->app_path());
        }
        
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

