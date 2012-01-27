<?php

/*
	Question2Answer 1.4.3 (c) 2011, Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-plugin/facebook-login/qa-plugin.php
	Version: 1.4.3
	Date: 2011-09-27 18:06:46 GMT
	Description: Initiates Facebook login plugin


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

/*
	Plugin Name: Google Login
	Plugin URI: 
	Plugin Description: Allows users to log in via Google
	Plugin Version: 0.5
	Plugin Date: 2012-01-26
	Plugin Author: Giuseppe Meloni
	Plugin Author URI: http://www.question2answer.org/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.3
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}


	qa_register_plugin_module('login', 'qa-google-login.php', 'qa_google_login', 'Google Login');
	

/*
	Omit PHP closing tag to help avoid accidental output
*/