<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 10/8/17
 * Time: 9:32 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('pagination');
        $this->load->library('Ajax_pagination');
        $this->perPage = 3;
        $this->load->model(array('frontend_model'));

        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function teachers() {

        $data['meta_title']      = "Our Teachers";
        $data['navigation']      = "teachers";
        $data['header']          = 'frontend/header';
        $data['page_content']    = 'frontend/teachers';
        $data['footer']          = 'frontend/footer';

        //total rows count
        $totalRec = count($this->frontend_model->getAllTeachers());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php?pages/ajaxPaginationTeachers';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['teachers'] = $this->frontend_model->getAllTeachers(array('limit'=>$this->perPage));

        $this->load->view('frontend/template', $data);
    }

    function ajaxPaginationTeachers()
    {
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->frontend_model->getAllTeachers());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php?pages/ajaxPaginationTeachers';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['teachers'] = $this->frontend_model->getAllTeachers(array('start'=>$offset, 'limit'=>$this->perPage));

        //load the view
        $this->load->view('frontend/ajax-pagination-teachers', $data, false);
    }

}