<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LoadIDcardAjax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    /** LOAD STUFFS FOR TEACHERS **/

    function show_teacher_phone()
    {
        global $data;
        if(!empty($_POST['teacher_id']))
        {
            $teacher_id  = $_POST['teacher_id'];

            $data = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->phone;
            echo $data;
        }
    }

    function show_teacher_name()
    {
        global $data;
        if(!empty($_POST['teacher_id']))
        {
            $teacher_id  = $_POST['teacher_id'];

            $data = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->name;
            echo $data;
        }
    }

    function show_teacher_dob()
    {
        global $data;
        if(!empty($_POST['teacher_id']))
        {
            $teacher_id  = $_POST['teacher_id'];

            $data = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->birthday;
            echo $data;
        }
    }

    function show_teacher_gender()
    {
        global $data;
        if(!empty($_POST['teacher_id']))
        {
            $teacher_id  = $_POST['teacher_id'];

            $data = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->sex;
            echo $data;
        }
    }

    function show_teacher_address()
    {
        global $data;
        if(!empty($_POST['teacher_id']))
        {
            $teacher_id  = $_POST['teacher_id'];

            $data = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row()->address;
            echo $data;
        }
    }

    /** LOAD STUFFS FOR STUDENTS **/

    function show_student_rollno()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->enroll_code;
            echo $data;
        }
    }

    function show_student_name()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
            echo $data;
        }
    }

    function show_student_code()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('student', array('student_id' => $student_id))->row()->student_code;
            echo $data;
        }
    }

    function show_student_dob()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('student', array('student_id' => $student_id))->row()->birthday;
            echo $data;
        }
    }

    function show_student_gender()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('student', array('student_id' => $student_id))->row()->sex;
            echo $data;
        }
    }

    function show_student_address()
    {
        global $data;
        if(!empty($_POST['student_id']))
        {
            $student_id  = $_POST['student_id'];

            $data = $this->db->get_where('student', array('student_id' => $student_id))->row()->address;
            echo $data;
        }
    }


}
