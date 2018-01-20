<?php

class Usuario{

	private $usu_int_codigo;
	private $usu_var_nome;
	private $usu_var_email;
	private $usu_var_senha;
	private $usu_cha_status;
	private $usu_dti_inclusao;

	public function getUsu_int_codigo() {
		return $this->usu_int_codigo;
	}

	public function setUsu_int_codigo($usu_int_codigo) {
		$this->usu_int_codigo = $usu_int_codigo;
	}

	public function getUsu_var_nome() {
		return $this->usu_var_nome;
	}

	public function setUsu_var_nome($usu_var_nome) {
		$this->usu_var_nome = $usu_var_nome;
	}

	public function getUsu_var_email() {
		return $this->usu_var_email;
	}

	public function setUsu_var_email($usu_var_email) {
		$this->usu_var_email = $usu_var_email;
	}

	public function getUsu_var_senha() {
		return $this->usu_var_senha;
	}

	public function setUsu_var_senha($usu_var_senha) {
		$this->usu_var_senha = $usu_var_senha;
	}

	public function getUsu_cha_status() {
		return $this->usu_cha_status;
	}

	public function setUsu_cha_status($usu_cha_status) {
		$this->usu_cha_status = $usu_cha_status;
	}

	public function getUsu_dti_inclusao() {
		return $this->usu_dti_inclusao;
	}

	public function setUsu_dti_inclusao($usu_dti_inclusao) {
		$this->usu_dti_inclusao = $usu_dti_inclusao;
	}

}
