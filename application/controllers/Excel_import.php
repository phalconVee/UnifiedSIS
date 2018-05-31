<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->database();
	}
	
	public function index()
	{
		$this->load->view('excel_import');
	}

	public function import_data()
	{
		$config = array(
			'upload_path'   => 'uploads/',
			'allowed_types' => 'xls|xlsx'
		);
		
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload('file')) 
		{
		    $error = array('error' => $this->upload->display_errors()); 
		    $this->load->view('excel_import', $error); 
		}
		else
		{
		    $data = $this->upload->data(); 
		    //$this->load->view('upload_success', $data);
		    @chmod($data['full_path'], 0777);

		    $this->load->library('Spreadsheet_Excel_Reader');

		    $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

		    $this->spreadsheet_excel_reader->read($data['full_path']);

		    $sheets = $this->spreadsheet_excel_reader->sheets[0];

		    //error_reporting(0);
		    error_reporting(E_ALL ^ E_NOTICE);

		    $data_excel = array();

			for ($i = 2; $i <= $sheets['numRows']; $i++) {

				if($sheets['cells'][$i][1] == '') break;

				$data_excel[$i - 1]['name']    = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['phone']   = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['address'] = $sheets['cells'][$i][3];

				// $data_excel[$i - 1]['name'] = $sheets['cells'][$i][1];
				// $data_excel[$i - 1]['roll'] = $sheets['cells'][$i][2];
				// $data_excel[$i - 1]['email'] = $sheets['cells'][$i][3];
				// $data_excel[$i - 1]['password'] = $sheets['cells'][$i][4];
				// $data_excel[$i - 1]['phone'] = $sheets['cells'][$i][5];
				// $data_excel[$i - 1]['email'] = $sheets['cells'][$i][6];
				// $data_excel[$i - 1]['address'] = $sheets['cells'][$i][7];
				// $data_excel[$i - 1]['gender'] = $sheets['cells'][$i][8];

			}

			$this->db->insert_batch('tb_import', $data_excel);
			@unlink($data_excel['full_path']);

			// echo '<pre>';
			// print_r($data_excel);
			// echo '</pre>';
			// die();

		}

		
	}
	

}
