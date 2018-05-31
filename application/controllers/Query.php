<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->library('Ebulk_sms');

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
    }

	public function index() {

		$query = $this->db->query("SELECT enroll_code, COUNT(*) c FROM enroll GROUP BY enroll_code HAVING c > 1");

        $sql = $query->result();

        var_dump($sql);

	}


}