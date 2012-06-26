<div class="center">
	<h3>You are now logged in!</h3>
	<p>Why don't you change your password?</p>
	<?php if($hasFailed) { ?>
		<div class="alert alert-error">Changing failed!</div>
	<?php }?>
	<?php 
		$current_password = array(
				'name'=>'current_password',
				'id'=>'password',
		);
		$password = array(
				'name'=>'password',
				'id'=>'password',
		);
		$password_conf = array(
				'name'=>'password_conf',
				'id'=>'password',
		);
	echo form_open('user/profile');
	?>
	<label for="current_password">Current password</label>
	<?php echo form_password($current_password);?>
	<label for="password">New Password</label>
	<?php echo form_password($password);?>
	<label for="password">Confirm New Password</label>
	<?php echo form_password($password_conf);?>
	<div class="errors">
		<?php echo validation_errors();?>
	</div>
	<?php echo form_submit(array('name'=>'change', 'value'=> 'Change', 'class'=>'btn btn-success'));?>
	<?php echo anchor(site_url('user/logout/'), 'Logout', array('class'=>'logout btn btn-danger'));?>
	<?php echo form_close(); ?>
</div>