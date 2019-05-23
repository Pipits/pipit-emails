<?php
    echo $HTML->title_panel([
        'heading' => $Lang->get('Editing email'),
    ], $CurrentUser);


    if($message) echo $message;
    

    if (is_object($Email)) {
        $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

        $Smartbar->add_item([
            'active' => true,
            'type'  => 'breadcrumb',
            'links' => [
                [
                    'title' => 'Emails',
                    'link'  => $API->app_nav(),
                    'translate' => false,
                ],
                [
                    'title' => $Email->title(),
                    'link'  => $API->app_nav() . '/edit/?id=' .$Email->id(),
                    'translate' => false,
                ]
            ],
        ]);

        echo $Smartbar->render();
    }



    echo $HTML->heading2('Email');

    echo $EditForm->form_start();
        echo $EditForm->fields_from_template($Template, $details);
        echo $EditForm->submit_field('btnSubmit', 'Save', $API->app_path());
    echo $EditForm->form_end();