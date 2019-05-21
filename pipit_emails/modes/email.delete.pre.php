<?php
    
    $Emails = new PipitEmails_Emails($API);
    $Form = $API->get('Form');
	$message = false;
    

    if (!$CurrentUser->has_priv('pipit_emails.email.delete')) {
        PerchUtil::redirect($API->app_path());
    }
	
	if (isset($_GET['id']) && $_GET['id']!='') {
	    $Email = $Emails->find($_GET['id']);
	}
	
	
	if (!is_object($Email)) PerchUtil::redirect($API->app_path());
	
	
	$Form->set_name('delete');

    if ($Form->submitted()) {
    	if (is_object($Email)) {
    	    $Email->delete();
    	    
    	    if ($Form->submitted_via_ajax) {
    	        echo $API->app_path();
    	        exit;
    	    }else{
    	       PerchUtil::redirect($API->app_path()); 
    	    }
    	    
            
        }else{
            $message = $HTML->failure_message('Sorry, that Email could not be deleted.');
        }
    }

    
    
    $details = $Email->to_array();


