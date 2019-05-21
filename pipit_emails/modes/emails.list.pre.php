<?php
    $Emails = new PipitEmails_Emails($API);
    $Emails->attempt_install();

    $message = '';

    $emails = $Emails->all();