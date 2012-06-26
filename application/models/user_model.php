<?php
class User_model extends CI_Model {

	function register($username, $email, $password, $activation_key) {
		$data = array('username' => $username, 'email' => $email, 'password' => $password, 'activation_key' => $activation_key);
		$this->db->insert('users', $data);
	}

	function isExistingUsername($username) {
		$this->db->where('username', $username);
		$this->db->from('users');
		return $this->db->count_all_results() != 0;
	}

	function isExistingEmail($email) {
		$this->db->where('email', $email);
		$this->db->from('users');
		return $this->db->count_all_results() != 0;
	}

	function userConfirm($email, $activation_key) {
		$data = array(
				'email' => $email,
				'activation_key' => $activation_key,
				'active' => 0
		);
		$this->db->where($data);
		$this->db->from('users');
		if ($this->db->count_all_results() == 1) {
			$this->db->where('email', $email);
			$this->db->update('users', array('active' => 1, 'activation_key' => ''));
			return true;
		}
		return false;
	}

	function tryLogin($email, $password) {
		$this->db->where(array('email' => $email,'password' => $password,'active' => 1));
		$this->db->from('users');
		return $this->db->count_all_results() == 1;
	}

	function passwordChange($email,$current_password, $new_password, $new_activation_key) {
		$data = array(
				'password' => $new_password,
				'active' => 0,
				'activation_key' => $new_activation_key
		);
		$this->db->where(array('email' => $email, 'password' => $current_password));
		$this->db->update('users', $data);
		return $this->db->affected_rows() == 1;
	}
}