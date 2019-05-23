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
                    ],
                    [
                        'title' => 'Preview',
                        'link'  => $API->app_nav() . '/edit/?id=' .$Email->id(),
                    ],
                ],
            ]);


            $Smartbar->add_item([
                'active'        => false,
                'link'          => $API->app_nav() . '/edit/?id=' .$Email->id(),
                'title'         => 'Edit',
                'icon'          => 'core/pencil',
                'position'      => 'end',
            ]);

        echo $Smartbar->render();
    }


    // render Email in iframe
    $iframe_src = $API->app_path() . '/render/?id=' . $Email->id();
    echo '<iframe src="'. $iframe_src .'" style="width:97%; height:80vh; margin-left:24px; border:1px solid #e9eaea"></iframe>';
