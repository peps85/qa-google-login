<?php

/*
	Question2Answer 1.4.3 (c) 2011, Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-plugin/facebook-login/qa-facebook-login.php
	Version: 1.4.3
	Date: 2011-09-27 18:06:46 GMT
	Description: Login module class for Facebook login plugin


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
			require_once 'openid.php';
			$openid = new LightOpenID("cting.org"); // CHANGE IT
		
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
				} else {
					echo "The user has not logged in";
				}
			} else {
				echo "Go to index page to log in.";
			}			
		}
		
		function match_source($source)
		{
			return $source=='google';
		}
		
		function login_html($tourl, $context)
		{
			require_once 'openid.php';
			$openid = new LightOpenID("my-domain.com");
			 
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array(
			  'namePerson/first',
			  'namePerson/last',
			  'contact/email',
			);
			$openid->returnUrl = 'http://cting/~peps/index.php'
			?>
 
			<a href="<?php echo $openid->authUrl() ?>">Login with Google</a>
			
			<?php
		}
		
		function logout_html($tourl)
		{
			session_destroy();
		}
		
		function admin_form()
		{
			$saved=false;
			
			if (qa_clicked('facebook_save_button')) {
				qa_opt('facebook_app_id', qa_post_text('facebook_app_id_field'));
				qa_opt('facebook_app_secret', qa_post_text('facebook_app_secret_field'));
				$saved=true;
			}
			
			$ready=strlen(qa_opt('facebook_app_id')) && strlen(qa_opt('facebook_app_secret'));
			
			return array(
				'ok' => $saved ? 'Facebook application details saved' : null,
				
				'fields' => array(
					array(
						'label' => 'Your Facebook App ID:',
						'value' => qa_html(qa_opt('facebook_app_id')),
						'tags' => 'NAME="facebook_app_id_field"',
					),

					array(
						'label' => 'Your Facebook App Secret:',
						'value' => qa_html(qa_opt('facebook_app_secret')),
						'tags' => 'NAME="facebook_app_secret_field"',
						'error' => $ready ? null : 'To use Facebook Login, please <A HREF="http://developers.facebook.com/setup/" TARGET="_blank">set up a Facebook application</A>.',
					),
				),
				
				'buttons' => array(
					array(
						'label' => 'Save Changes',
						'tags' => 'NAME="facebook_save_button"',
					),
				),
			);
		}
		
	};
	

/*
	Omit PHP closing tag to help avoid accidental output
*/