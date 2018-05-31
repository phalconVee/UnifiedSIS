<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 10/4/17
 * Time: 9:44 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

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

    public function index() {

        $data['meta_title']      = "Home";
        $data['navigation']      = "home";
        $data['header']          = 'frontend/header';
        $data['slider']          = 'frontend/slider';
        $data['page_content']    = 'frontend/home';
        $data['footer']          = 'frontend/footer';

        $data['noticeBoard'] = $this->frontend_model->get_noticeboard();
        $data['homepage_note_title'] = $this->db->get_where('settings_frontend' , array('type'=>'homepage_note_title'))->row()->description;
        $data['homepage_note_description'] = $this->db->get_where('settings_frontend' , array('type'=>'homepage_note_description'))->row()->description;
        $data['events'] = $this->frontend_model->get_latest_events();


        $data['total_subjects'] = $this->db->get('subject')->num_rows();
        $data['total_students'] = $this->db->get('student')->num_rows();
        $data['total_teachers'] = $this->db->get('teacher')->num_rows();

        $this->load->view('frontend/template', $data);
    }

}