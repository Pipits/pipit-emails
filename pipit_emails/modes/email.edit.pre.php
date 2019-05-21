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



    $EditForm = $API->get('Form');
    $EditForm->set_name('edit');
    $EditForm->handle_empty_block_generation($Template);
    $EditForm->set_required_fields_from_template($Template, $details);


    if ($EditForm->submitted()) {
        $data = array();
        $prev = false;

        if (isset($details['dynamicFields'])) {
            $prev = PerchUtil::json_safe_decode($details['dynamicFields'], true);
        }

        $dynamic_fields = $EditForm->receive_from_template_fields($Template, $prev, $Emails, $Email, false, false);
        $static_fields = $EditForm->get_posted_content($Template, $Emails, $Email);
        $data['dynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);


        $data = array_merge($data, $static_fields);


        if (is_object($Email)) {        
            
            $result = $Email->update($data);

            if($result) {
                $message = $HTML->success_message('Email has been successfully updated. Return to %sall emails%s', '<a href="'.$API->app_path().'">', '</a>');
            } else {
                $message = $HTML->failure_message('Sorry, this email could not be updated.');
            }

        } else {

            $Email = $Emails->create($data);

            if($Email) {
                PerchUtil::redirect($API->app_path() .'/edit/?id='.$Email->id().'&created=1');
            } else {
                $message = $HTML->failure_message('Sorry, this email could not be created.');
            }

        }
    }
    



    if (is_object($Email)) {
        $details = $Email->to_array();
        if(isset($_GET['created']) && $_GET['created'] == '1') {
            $message = $HTML->success_message('Your email has been successfully created. Return to %sall emails%s', '<a href="'.$API->app_path().'">', '</a>');
        }
    } else {
        $details = array();
    }