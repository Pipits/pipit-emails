<?php
    if (!defined('PERCH_DB_PREFIX')) exit;

    $sql = "CREATE TABLE IF NOT EXISTS `__PREFIX__pipit_emails` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL  DEFAULT '',
                `event` varchar(255) DEFAULT NULL,
                `enabled` varchar(255) NOT NULL  DEFAULT '1',
                `template` varchar(255) NOT NULL DEFAULT 'default.html',
                `dynamicFields` mediumtext,
                `created` datetime NOT NULL DEFAULT '2019-01-01 00:00:00',
                `updated` datetime NOT NULL DEFAULT '2019-01-01 00:00:00',
                PRIMARY KEY (`id`)
            ) CHARSET=utf8;";


    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);

    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }

    $API = new PerchAPI(1.0, 'pipit_emails');
    $UserPrivileges = $API->get('UserPrivileges');
    $UserPrivileges->create_privilege('pipit_emails', 'Access the Emails app');
    $UserPrivileges->create_privilege('pipit_emails.email.create', 'Create emails');
    $UserPrivileges->create_privilege('pipit_emails.email.edit', 'Edit existing emails');
    $UserPrivileges->create_privilege('pipit_emails.email.delete', 'Delete emails');

    $Settings = $API->get('Settings');
	$Settings->set('pipit_emails_update', PIPIT_EMAILS_VERSION);