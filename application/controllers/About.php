<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 10/7/17
 * Time: 8:49 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class About extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model(array('frontend_model'));

        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function brief_history() {

        $data['meta_title']      = "Brief History";
        $data['navigation']      = "about";
        $data['header']          = 'frontend/header';
        $data['page_content']    = 'frontend/about_us';
        $data['footer']          = 'frontend/footer';

        $data['school_title']    =	$this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;

        $data['about_us']    =	$this->db->get_where('settings_frontend' , array('type'=>'about_us'))->row()->description;

        $data['total_subjects'] = $this->db->get('subject')->num_rows();
        $data['total_students'] = $this->db->get('student')->num_rows();
        $data['total_teachers'] = $this->db->get('teacher')->num_rows();

        $this->load->view('frontend/template', $data);
    }

    public function admissions() {

        $data['meta_title']      = "Admission Process";
        $data['navigation']      = "admissions";
        $data['header']          = 'frontend/header';
        $data['page_content']    = 'frontend/admissions';
        $data['footer']          = 'frontend/footer';

        $data['school_title'] =	$this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;

        $data['address'] =	$this->db->get_where('settings_frontend' , array('type'=>'address'))->row()->description;
        $data['phone']   =	$this->db->get_where('settings_frontend' , array('type'=>'phone'))->row()->description;

        $this->load->view('frontend/template', $data);
    }

}