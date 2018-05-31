<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 10/8/17
 * Time: 8:48 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('pagination');
        $this->load->library('Ajax_pagination');
        $this->perPage = 9;
        $this->load->model(array('frontend_model'));

        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {

        $data['meta_title']      = "Events";
        $data['navigation']      = "events";
        $data['header']          = 'frontend/header';
        $data['page_content']    = 'frontend/events';
        $data['footer']          = 'frontend/footer';

        //total rows count
        $totalRec = count($this->frontend_model->getAllEvents());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php?events/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['events'] = $this->frontend_model->getAllEvents(array('limit'=>$this->perPage));

        $this->load->view('frontend/template', $data);
    }

    function ajaxPaginationData()
    {
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->frontend_model->getAllEvents());

        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php?events/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['events'] = $this->frontend_model->getAllEvents(array('start'=>$offset,'limit'=>$this->perPage));

        //load the view
        $this->load->view('frontend/ajax-pagination-events', $data, false);
    }



}