<div class="center">
	<h2>Log in here!</h2>

	<div class="alert alert-error hide" id="login-error">Login failed!</div>

	<?php echo form_open('user/login'); ?>
	<?php 
		$email = array(
				'name'=>'email',
				'id'=>'email',
				'value'=>set_value('email')
		);	
		$password = array(
				'name'=>'password',
				'id'=>'password',
		);
	?>
	<label for="email">Email</label>
	<?php echo form_input($email);?>
	<label for="password">Password</label>
	<?php echo form_password($password);?>
	<br/>	
	<div class="errors">
		<?php echo validation_errors();?>
	</div>	
	<?php echo form_submit(array('id'=>'login','name'=>'submit', 'value'=> 'Log in!', 'class'=>'btn btn-primary'));?>
	<?php echo anchor(site_url('/user/register'), 'Register', array('id'=>'register','class'=>'register btn btn-inverse'));?>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('#login').click(function(){
		$.ajax({
			url: "<?php echo site_url('user/login');?>",
			type: 'POST',
			dataType: 'json',
			data: {
				'email': $('#email').val(),
				'password': $('#password').val()
			},
			success: function(response){
				if (response) {
					window.location = <?php echo json_encode(site_url('/user/profile')); ?>;
				} else {
					$('#login-error').show();
				}
			} 
		});
		return false;
	});
</script>
	