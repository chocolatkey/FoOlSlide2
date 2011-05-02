<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->tank_auth->is_logged_in() or redirect('/admin/auth/login');
		$this->viewdata["controller_title"] = _('Dashboard');
	}

	function index() {

		$this->viewdata["main_content_view"] = $this->load->view("admin/dashboard/index", NULL, TRUE);
		$this->load->view("admin/default", $this->viewdata);
	}

}