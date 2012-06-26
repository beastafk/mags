<?php
class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('form_validation');
		$this->load->helper('string');
	}

	public function index() {
		$this->login();
	}

	public function register() {
		if($this->session->userdata('logged_in')) {
			return redirect(site_url('/user/profile'));
		}

		if($this->form_validation->run('register') == FALSE) {
			$this->template->load('template', 'registration');
		} else {
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$activation_key = random_string('alnum', 20);
			$this->User_model->register($username, $email, $password, $activation_key);

			$this->load->library('email');
			$this->config->load('email_sender', true);
			$this->email->from($this->config->item('address', 'email_sender'), $this->config->item('name', 'email_sender'));
			$this->email->to($email);
			$this->email->subject('Registration confirmation');
			$this->email->message('Hello '.$username.', In order to complete your registration, please click this link '.anchor(site_url('/user/confirm/'.urlencode($email).'/'.$activation_key), 'here'));

			if($this->email->send()) {
				return $this->template->load('template', 'success',
						array('message' => 'Registration completed! Please confirm your account from your e-mail and log in '.anchor(site_url('/user/login'), 'here')));
			} else {
				return $this->template->load('template', 'error', array('message' => 'Registration error!'));
			}
		}
	}

	function confirm () {
		$email = urldecode($this->uri->segment(3));
		$activation_key = $this->uri->segment(4);
		if($activation_key == '') {
			return $this->template->load('template', 'error', array('message' => 'Confirmation error!'));
		}
		if($this->User_model->userConfirm($email, $activation_key)) {
			return $this->template->load('template', 'success', array('message' => 'Confirmation completed! You can now login '.anchor(site_url('/user/login'), 'HERE')));
		} else {
			return $this->template->load('template', 'error', array('message' => 'Confirmation error!'));
		}
	}

	function uniqueUsername($username) {
		if($this->User_model->isExistingUsername($username)) {
			$this->form_validation->set_message('uniqueUsername', 'That %s already exists, please choose another one.');
			return false;
		}
		return true;
	}

	function uniqueEmail($email) {
		if($this->User_model->isExistingEmail($email)) {
			$this->form_validation->set_message('uniqueEmail', 'That %s already exists, please choose another one.');
			return false;
		}
		return true;
	}

	function login() {
		if($this->input->is_ajax_request()) {
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			if($this->User_model->tryLogin($email, $password)) {
				$this->load->library('session');
				$newdata = array(
						'email'   => $email,
						'logged_in' => TRUE
				);
				$this->session->set_userdata($newdata);
				die('true');
			}
			die('false');
		}
		$this->template->load('template', 'login', array('hasFailed' => false));
	}

	function profile() {
		if(!$this->session->userdata('logged_in')) {
			return redirect(site_url('/user/login'));
		}

		if($this->form_validation->run('profile') == FALSE) {
			$this->template->load('template', 'profile', array('hasFailed' => false));
		} else {
			$email = $this->session->userdata('email');
			$current_password = $this->input->post('current_password');
			$new_password= $this->input->post('password');
			$new_activation_key = random_string('alnum', 20);
			if ($this->User_model->passwordChange($email,$current_password, $new_password, $new_activation_key)) {
				$this->load->library('email');
				$this->config->load('email_sender', true);
				$this->email->from($this->config->item('address', 'email_sender'), $this->config->item('name', 'email_sender'));
				$this->email->to($email);
				$this->email->subject('Password change confirmation');
				$this->email->message('In order to confirm your new password, click here '.anchor(site_url('/user/confirm/'.urlencode($email).'/'.$new_activation_key), 'here'));

				if($this->email->send()) {
					$this->session->unset_userdata('email');
					return $this->template->load('template', 'success', array('message' => 'Password changed successfully! Please confirm it from your e-mail and log in '.anchor(site_url('/user/login'), 'HERE')));
				} else {
					return $this->template->load('template', 'error', array('message' => 'Registration error!'));
				}
			}

			$this->template->load('template', 'profile', array('hasFailed' => true));
		}
	}

	function logout() {
		$this->session->sess_destroy();
		return redirect(site_url('/user/login'));
	}
}
?>