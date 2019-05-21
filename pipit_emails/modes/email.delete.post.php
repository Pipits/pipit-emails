<?php
   
   echo $HTML->title_panel([
        'heading' => $Lang->get('Delete a Email'),
    ], $CurrentUser);
    

    
    if ($message) {
        echo $message;
    }else{
        echo $HTML->warning_block(sprintf('Are you sure you wish to delete the Email: %s?', $details['name']), 'Deleted emails cannot be retrieved');
        echo $Form->form_start();
        echo $Form->hidden('id', $details['id']);
		echo $Form->submit_field('btnSubmit', 'Delete', $API->app_path());

        echo $Form->form_end();
    }
    

?>