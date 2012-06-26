<?php
$config = array(
		'register' => array(
				array(
						'field' => 'username',
						'label' => 'Username',
						'rules' => 'trim|required|alpha_numeric|min_length[6]|xss_clean|callback_uniqueUsername'
				),
				array(
						'field' => 'email',
						'label' => 'E-mail',
						'rules' => 'trim|required|valid_email|callback_uniqueEmail'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required|min_length[6]|md5'
				),
				array(
						'field' => 'password_conf',
						'label' => 'Password confirmation',
						'rules' => 'trim|required|min_length[6]|matches[password]|md5'
				),
		),
		'login' => array(
				array(
						'field' => 'email',
						'label' => 'E-mail',
						'rules' => 'trim|required|valid_email'
				),
				array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'trim|required|min_length[6]|md5'
				),
		),
		'profile' => array(
				array(
						'field' => 'current_password',
						'label' => 'Current Password',
						'rules' => 'trim|required|min_length[6]|md5'
				),
				array(
						'field' => 'password',
						'label' => 'New Password',
						'rules' => 'trim|required|min_length[6]|md5'
				),
				array(
						'field' => 'password_conf',
						'label' => 'Confirm New Password',
						'rules' => 'trim|required|min_length[6]|matches[password]|md5'
				),
		)
);
?>