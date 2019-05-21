<?php
	PerchUI::set_subnav([
		[
			'page' => ['pipit_emails','pipit_emails/edit','pipit_emails/delete'], 
			'label' => 'Emails',
			'priv'  => 'pipit_emails',
		],
	], $CurrentUser);