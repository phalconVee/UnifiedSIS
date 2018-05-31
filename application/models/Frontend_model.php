<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 10/4/17
 * Time: 10:00 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_noticeboard() {
        $this->db->limit(3);
        $this->db->order_by('notice_id', 'desc');
        $query = $this->db->get('noticeboard');

        return $query->result_array();
    }

    function getAllNoticeBoard($params = array()){
        $this->db->select('*');
        $this->db->from('noticeboard');
        $this->db->order_by('notice_id','desc');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getAllEvents($params = array()){
        $this->db->select('*');
        $this->db->from('events');
        $this->db->order_by('event_id','desc');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

    function getAllTeachers($params = array()){
        $this->db->select('*');
        $this->db->from('teacher');
        $this->db->order_by('teacher_id','desc');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }


    function get_latest_events() {
        $this->db->limit(3);
        $this->db->order_by('event_id', 'desc');
        $query = $this->db->get('events');

        return $query->result_array();
    }

}