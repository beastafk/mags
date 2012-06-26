<div class="center">
	<h2>Fill the form to register!</h2>
	<?php echo form_open('user/register'); ?>
	<?php 
		$username = array(
				'name'=>'username',
				'id'=>'username',
				'value'=>set_value('username')
		);
		$email = array(
				'name'=>'email',
				'id'=>'email',
				'value'=>set_value('email')
		);
		$password = array(
				'name'=>'password',
				'id'=>'password'
		);
		$password_conf = array(
				'name'=>'password_conf',
				'id'=>'password_conf'
		);
	?>
	<label for="name">Username</label>
	<?php echo form_input($username);?>
	<label for="email">Email</label>
	<?php echo form_input($email);?>
	<label for="password">Password</label>
	<?php echo form_password($password);?>
	<label for="password">Password Confirm</label>
	<?php echo form_password($password_conf);?>
	<br />
	<div class="errors">
		<?php echo validation_errors();?>
	</div>
	<?php echo form_submit(array('name'=>'submit', 'value'=> 'Register', 'class'=>'btn btn-primary'));?>
	<?php echo anchor(site_url('user/login/'), 'Login', array('class'=>'logout btn btn-success'));?>
	<?php echo form_close(); ?>
</div>
