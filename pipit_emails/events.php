<?php

    $API  = new PerchAPI(1.0, 'pipit_emails');

    $Settings = $API->get('Settings');
    // only run if installed
    if ($Settings->get('pipit_emails_update')->val()) {
        if(!strpos($_SERVER['REQUEST_URI'], 'pipit_emails') !== false) {
            $Emails = new PipitEmails_Emails($API);
            $emails = $Emails->get_by('enabled', 1);

            $API_Email = $API->get('Email');
            $event_handlers = include(PerchUtil::file_path(PERCH_PATH . '/config/pipit_emails_event_handlers.php'));

            if(PerchUtil::count($emails)) {
                foreach($emails as $Email) {
                    if($Email->event()) {
                        $API->on($Email->event(), function(PerchSystemEvent $Event) use($Email, $API_Email, $event_handlers){
                            // event linked to an email was fired
                            //PerchUtil::debug($Event);
                            //PerchUtil::debug($Email);


                            $sender_name = PERCH_EMAIL_FROM_NAME;
                            $sender_email = PERCH_EMAIL_FROM;
                            if($Email->sender_name()) $sender_name = $Email->sender_name();
                            if($Email->sender_email()) $sender_email = $Email->sender_email();

                            $API_Email->senderName($sender_name);
                            $API_Email->senderEmail($sender_email);
                            $API_Email->replyToEmail($sender_email);
                            $API_Email->subject($Email->subject());

                            // get recepient email address(es)
                            if($Email->from_event() == 1) {
                                $recipient = '';
                                foreach($event_handlers as $key => $handler) {
                                    if($key == $Event->event) {
                                        $recipient = $handler($Event);
                                        //PerchUtil::debug($recipient);
                                    }
                                }

                                if(isset($recipient)) {
                                    $API_Email->recipientEmail($recipient);
                                }

                            } else {
                                $API_Email->recipientEmail(explode(',', $Email->recipients()));
                            }

                            // Get dynamic event data for templating
                            $event_data = [];
                            if($Event->subject) {
                                switch(gettype($Event->subject)) {
                                    case 'array':
                                        foreach($Event->subject as $key => $value) {
                                            $event_data['event_' . $key] = $value;
                                        }
                                        break;

                                    case 'object':
                                        // PerchBase objects has to_array() function
                                        if(method_exists($Event->subject, 'to_array')) {
                                            foreach($Event->subject->to_array() as $key => $value) {
                                                $event_data['event_' . $key] = $value;
                                            }
                                        }
                                        break;
                                }
                            }
                            // PerchUtil::debug($event_data);

                            if($Email->template() != '') {
                                $API_Email->set_template('emails/'.$Email->template());
                                $API_Email->template_method('perch');
                                $API_Email->set_bulk(array_merge($Email->to_array(), $event_data));
                            }


                            //PerchUtil::debug($API_Email);
                            $API_Email->send();
                        });
                    }
                }
            }
        }
    } else {
        PerchUtil::debug('Pipit Emails event listeners disabled. App installation incomplete.', 'notice');
    }

