<?php
    
    echo $HTML->title_panel([
        'heading' => $Lang->get('Emails'),
        'button'  => [
            'text' => $Lang->get('Add email'),
            'link' => $API->app_nav().'/edit/',
            'icon' => 'core/plus',
            'priv' => 'pipit_emails.email.create',
        ]
    ], $CurrentUser);

    
    if($message) {
        echo $HTML->warning_block($message, '');
    }




    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);
        $Smartbar->add_item([
            'title' => 'Emails',
            'link'  => $API->app_nav(),
            'icon'  => 'blocks/mail',
            'active' => true
        ]);
    echo $Smartbar->render();


    
    $AdminListing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

        $AdminListing->add_col([
            'title'     => 'Title',
            'value'     => 'title',
            'edit_link' => 'edit',
            'sort' => 'title'
        ]);

        $AdminListing->add_col([
            'title'     => 'Enabled',
            'value'     => function($email) {
                if($email->enabled() == 1) {
                    return PerchUI::icon('core/circle-check', 16, null, 'icon-status-success');
                } else {
                    return PerchUI::icon('core/cancel', 16, null, 'icon-status-alert');
                }
            },
        ]);

        $AdminListing->add_delete_action([
            'priv'   => 'pipit_emails.email.delete',
            'inline' => true,
            'path'   => 'delete',
        ]);

    echo $AdminListing->render($emails);
