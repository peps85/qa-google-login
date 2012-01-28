<?php

/*
	Question2Answer 1.4.3 (c) 2011, Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-plugin/google-login/qa-google-login.php
	Version: 1.4.3
	Date: 2011-09-27 18:06:46 GMT
	Description: Login module class for Google login plugin


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

	class qa_google_login {
		
		var $directory;
		var $urltoroot;
		
		function load_module($directory, $urltoroot)
		{
			$this->directory=$directory;
			$this->urltoroot=$urltoroot;
		}
		
		function check_login()
		{
			$site_domain=qa_opt('google_site_domain');
			if (!(strlen($site_domain)))
				return;
		
			require_once 'openid.php';
			$openid = new LightOpenID($site_domain);
		
			if ($openid->mode) {
				if ($openid->mode == 'cancel') {
					echo "User has canceled authentication !";
				} elseif($openid->validate()) {
					$data = $openid->getAttributes();
					$email = $data['contact/email'];
					$first = $data['namePerson/first'];					
					qa_log_in_external_user('google', $openid->identity, array(
								'email' => @$email,
								'handle' => @$first,
								'confirmed' => @true,								
							));
				} 
			} 		
		}
		
		function match_source($source)
		{
			return $source=='google';
		}
		
		function login_html($tourl, $context)
		{
			$site_domain=qa_opt('google_site_domain');
			if (!(strlen($site_domain)))
				return;
				
			require_once 'openid.php';
			$openid = new LightOpenID($site_domain);
			 
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array(
			  'namePerson/first',
			  'namePerson/last',
			  'contact/email',
			);

			?>
 
			<a href="<?php echo $openid->authUrl() ?>">Login with Google</a>
			
			<?php
		}
		
		function logout_html($tourl)
		{
			$site_domain=qa_opt('google_site_domain');
			if (!(strlen($site_domain)))
				return;
            ?>
			    <a href="?qa=logout">Logout</a> 
			<?			
		}
		
		function admin_form()
		{
			$saved=false;
			
			if (qa_clicked('google_login_save_button')) {
				qa_opt('google_site_domain', qa_post_text('google_site_domain_field'));				
				$saved=true;
			}
			
			$ready=strlen(qa_opt('google_site_domain')); 
			
			return array(
				'ok' => $saved ? 'Google application details saved' : null,
				
				'fields' => array(
					array(
						'label' => 'Your Site Domain (like example.com):',
						'value' => qa_html(qa_opt('google_site_domain')),
						'tags' => 'NAME="google_site_domain_field"',
					),
				),
				
				'buttons' => array(
					array(
						'label' => 'Save Changes',
						'tags' => 'NAME="google_login_save_button"',
					),
				),
			);
		}
		
	};
	

/*
	Omit PHP closing tag to help avoid accidental output
*/
