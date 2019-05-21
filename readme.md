# Pipit Emails

The Emails app enables you to create editable emails via the Perch control panel to be sent when an event is fired by another Perch app.


## Installation

* Download the latest version of the Emails App.
* Unzip the download
* Place the `pipit_emails` folder in `perch/addons/apps`
* Add `pipit_emails` to your `perch/config/apps.php`
* Create `perch/config/pipit_emails_event_handlers.php` (see [event handlers](#event-handlers))


## Requirements

* Perch or Perch Runway 3.0 or higher
* PHP 7+



## Event handlers

An event fired by a Perch app can make some relevant data about the event accessible including an email address (e.g. a customer email address). Since there is no uniform way for events to return these email addresses (if any), it is not possible for Pipit Emails to have built-in support for all events.

This is why you can add your own handlers for as many event as you need in `perch/config/pipit_emails_event_handlers.php`.

As a minimum, you need to return an empty array:

```php
<?php
    return array();
```


If an app fires an event like so:

```php
$API->event('pipit_emails.test', ['email' => 'hello@example.com']);
```

You would add an element to the array with a key that corresponds to the event name. The value of this element should be a callable function that returns the value of the email address.

```php
<?php
    return [
        'pipit_emails.test' => function(PerchSystemEvent $Event) {
            if(isset($Event->subject['email'])) {
                return $Event->subject['email'];
            }

            return false;
        }
    ];
```


### Built-in event handlers

None so far. This is an early version of the app. 