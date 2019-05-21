<?php
    echo $HTML->title_panel([
        'heading' => $Lang->get('Editing email'),
    ], $CurrentUser);


    if($message) echo $message;
    





    echo $HTML->heading2('Email');

    echo $EditForm->form_start();
        echo $EditForm->fields_from_template($Template, $details);
        echo $EditForm->submit_field('btnSubmit', 'Save', $API->app_path());
    echo $EditForm->form_end();