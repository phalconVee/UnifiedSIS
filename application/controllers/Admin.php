<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Admin extends CI_Controller
{
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

    /***default function, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $this->load->model('crud_model');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');

        $page_data['notices'] = $this->crud_model->get_noticeboard();

        /*$query = $this->db->get('students')->result_array();

        foreach($query as $row){
            $birthday = $row['birthday'];

            if(date('m/d') == substr($birthday,5,5) or (date('y')%4 <> 0 and substr($birthday,5,5)=='02-29' and date('m/d')=='02-28')){

            }
        }*/

        $page_data['birthday'] = $this->crud_model->count_no_of_birthdays();

        $status   = $this->crud_model->getStatus();
        $status_1 = $this->crud_model->getStaffStatus();

        $total1 = array();
        $total2 = array();

        foreach ($status as $stat) {
            $total1[] = $stat->status;
        }

        foreach ($status_1 as $stat2) {
            $total2[] = $stat2->status;
        }

        $bulan = $this->crud_model->getMonth();
        $label = array();
        foreach ($bulan as $m) {
            $label[] = date("m/d", $m->timestamp);
        }

        $bulan2 = $this->crud_model->getStaffMonth();
        $label2 = array();
        foreach ($bulan2 as $m2) {
            $label2[] = date("m/d", $m2->timestamp);
        }

        $page_data['label'] = json_encode($label);
        $page_data['result1'] = json_encode($total1);

        $page_data['label2'] = json_encode($label2);
        $page_data['result2'] = json_encode($total2);

        $this->load->view('backend/index', $page_data);
    }


    function bar_graph()
    {
        header('Content-Type: application/json');

        $status = $this->crud_model->getStatus();
        $total1 = array();

        foreach ($status as $stat) {
           $total1[] = $stat->status;
        }

        $bulan = $this->crud_model->getMonth();
        $label = array();
        foreach ($bulan as $m) {
            $label[] = $m->timestamp;
        }

        $data['label'] = json_encode($label);
        $data['result1'] = json_encode($total1);

        print json_encode($data);
    }

    function charts()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name']  = 'charts';
        $page_data['page_title'] = get_phrase('charts');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE STUDENTS CLASSWISE*****/
	function student_add()
	{
		if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

		$page_data['page_name']  = 'student_add';
		$page_data['page_title'] = get_phrase('add_student');
		$this->load->view('backend/index', $page_data);
	}

	function student_bulk_add($param1 = '')
	{
		if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        //$bulk_validation = 0;
        if($param1 == 'add_bulk_student') {

            $names     = $this->input->post('name');
            $emails    = $this->input->post('email');
            $passwords = $this->input->post('password');

            if ($this->input->post('roll') != null) {
                $rolls = $this->input->post('roll');
            }
            if ($this->input->post('phone') != null) {
                $phones = $this->input->post('phone');
            }
            if ($this->input->post('address') != null) {
                $addresses = $this->input->post('address');
            }
            if ($this->input->post('sex')) {
                $genders = $this->input->post('sex');
            }

            $student_entries = sizeof($names); //return the no. of names in the array
            for($i = 0; $i < $student_entries; $i++) {

                $data['name']     =   $names[$i];
                $data['email']    =   $emails[$i];
                $data['password'] =   sha1($passwords[$i]);
                $data['phone']    =   $phones[$i];
                $data['address']  =   $addresses[$i];
                $data['sex']      =   $genders[$i];

                //validate here, if the row(name, password) is empty or not
                if($data['name'] == '' || $data['password'] == '')
                    continue;

                $data['student_code'] = $this->generateStudentCode();

                //$validation = email_validation($data['email']);
                //if($validation == 1){

                $this->db->insert('student' , $data);
                $student_id = $this->db->insert_id();

                $data2['student_id']    =   $student_id;
                $data2['class_id']      =   $this->input->post('class_id');

                if($this->input->post('section_id') != '') {
                    $data2['section_id'] =   $this->input->post('section_id');
                }

                $data2['roll']          =   $rolls[$i];
                $data2['date_added']    =   strtotime(date("Y-m-d H:i:s"));
                $data2['year']          =   $this->db->get_where('settings' , array(
                                                'type' => 'running_year'
                                            ))->row()->description;

                $sessional_year = explode('-', $data2['year']);
                $year = $sessional_year[0];

                $rand_num = $this->generate_random_num();
                $data2['enroll_code']   =   $year.'/'.$rand_num;

                $this->db->insert('enroll' , $data2);

                /*}
                else{
                    $bulk_validation++;
                }*/
            }

            $this->session->set_flashdata('flash_message' , get_phrase('all_students_added'));
            redirect(base_url() . 'index.php?admin/student_information/' . $this->input->post('class_id') , 'refresh');

        }

		$page_data['page_name']  = 'student_bulk_add';
		$page_data['page_title'] = get_phrase('add_bulk_student');
		$this->load->view('backend/index', $page_data);
	}

    function get_sections($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/student_bulk_add_sections' , $page_data);
    }

    function get_classes_id_card($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/student_idcard_add_student' , $page_data);
    }

	function student_information($class_id = '')
	{
		if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= get_phrase('student_information'). " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);

		$page_data['class_id']   	= $class_id;
		$page_data['running_year'] 	= $running_year;
		$this->load->view('backend/index', $page_data);
	}

    function student_marksheet($student_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;

        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =   'student_marksheet';
        $page_data['page_title'] =   get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $running_year       =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;

        $section_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->section_id;

        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;

        $this->db->where('class_id' , $class_id);
        $this->db->where('section_id' , $section_id);
        $this->db->from('enroll');
        $no_in_class = $this->db->count_all_results();

        $page_data['no_in_class'] = $no_in_class;

        $class_average_query = $this->db->get_where('result', array(
            'exam_id' => $exam_id,
            'section_id' => $section_id,
            'class_id' => $class_id,
            'student_id' => $student_id,
            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ));

        if($class_average_query->num_rows() > 0) {
            $average = $class_average_query->row()->average;
            $page_data['average'] = $average;
        }else {
            $page_data['average'] = '0.00';
        }

        $position = $this->crud_model->get_position($class_id, $exam_id, $section_id, $student_id, $running_year);
        $page_data['position'] = $position;

        $last_value = substr($position, -1);
        if($last_value == 1 && $position != 11) {
            $page_data['super_script'] = 'st';
        } elseif($last_value == 2 && $position != 12) {
            $page_data['super_script'] = 'nd';
        }elseif($last_value == 3 && $position != 13) {
            $page_data['super_script'] = 'rd';
        }else {
            $page_data['super_script'] = 'th';
        }

        //get days absent
        $this->db->where('student_id' , $student_id);
        $this->db->where('year' , $running_year);
        $this->db->where('status' , '1');
        $this->db->from('attendance');
        $page_data['days_absent'] = $this->db->count_all_results();

        //get days present
        $this->db->where('student_id' , $student_id);
        $this->db->where('year' , $running_year);
        $this->db->where('status' , '2');
        $this->db->from('attendance');
        $page_data['days_present'] =  $this->db->count_all_results();

        //no of subject taken
        $this->db->where('class_id' , $class_id);
        $this->db->where('exam_id' , $exam_id);
        $this->db->where('section_id' , $section_id);
        $this->db->where('student_id' , $student_id);
        $this->db->where('year' , $running_year);
        $this->db->where('total_score != ', 0, FALSE);
        $this->db->from('mark');
        $page_data['no_of_subjects'] = $this->db->count_all_results();

        $page_data['student_id']   =   $student_id;
        $page_data['class_id']     =   $class_id;
        $page_data['section_id']   =   $section_id;
        $page_data['exam_id']      =   $exam_id;

        $page_data['page_title']   =   get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $this->load->view('backend/admin/student_marksheet_print_view_2', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;

        if ($param1 == 'create') {

            $data['name'] = $this->input->post('name');

            if($this->input->post('other_name') != null){
              $data['other_name'] = $this->input->post('other_name');
            }

            if($this->input->post('birthday') != null){
              $data['birthday'] = $this->input->post('birthday');
            }

            if($this->input->post('place_of_birth') != null){
              $data['place_of_birth'] = $this->input->post('place_of_birth');
            }

            if($this->input->post('sex') != null){
              $data['sex'] = $this->input->post('sex');
            }

            if($this->input->post('religion') != null){
              $data['religion'] = $this->input->post('religion');
            }

            if($this->input->post('blood_group') != null){
              $data['blood_group'] = $this->input->post('blood_group');
            }

            if($this->input->post('address') != null){
              $data['address'] = $this->input->post('address');
            }

            if($this->input->post('nationality') != null){
              $data['nationality'] = $this->input->post('nationality');
            }

            if($this->input->post('state_id') != null){
              $data['state_id'] = $this->input->post('state_id');
            }

            if($this->input->post('local_id') != null){
              $data['local_id'] = $this->input->post('local_id');
            }

            if($this->input->post('phone') != null){
              $data['phone'] = $this->input->post('phone');
            }

            $data['email']    = $this->input->post('email');
            $data['password'] = sha1($this->input->post('password'));

            if($this->input->post('parent_id') != null){
                $data['parent_id']    = $this->input->post('parent_id');
            }

            if($this->input->post('dormitory_id') != null){
                $data['dormitory_id'] = $this->input->post('dormitory_id');
            }

            if($this->input->post('transport_id') != null){
                $data['transport_id'] = $this->input->post('transport_id');
            }

            $data['student_code'] = $this->generateStudentCode();

            //$validation = email_validation($data['email']);

            //if($validation == 1){

            $this->db->insert('student', $data);
            $student_id = $this->db->insert_id();

            $data2['student_id']  = $student_id;

            if($this->input->post('class_id') != null){
                $data2['class_id'] = $this->input->post('class_id');
            }

            if ($this->input->post('section_id') != '') {
                $data2['section_id'] = $this->input->post('section_id');
            }

            if ($this->input->post('roll') != '') {
                $data2['roll'] = $this->input->post('roll');
            }

            $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
            $data2['year']           = $running_year;

            $sessional_year = explode('-', $running_year);
            $year = $sessional_year[0];

            $rand_num = $this->generate_random_num();
            $data2['enroll_code']   =   $year.'/'.$rand_num;

            $this->db->insert('enroll', $data2);

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            //$this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL

            redirect(base_url() . 'index.php?admin/student_add/', 'refresh');

            }

            /*else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }*/

        //}

        if ($param1 == 'do_update') {

            $data['name']       = $this->input->post('name');
            $data['email']      = $this->input->post('email');
            $data['parent_id']  = $this->input->post('parent_id');


            if($this->input->post('other_name') != null){
              $data['other_name'] = $this->input->post('other_name');
            }

            if ($this->input->post('birthday') != null) {
                $data['birthday']   = $this->input->post('birthday');
            }

            if($this->input->post('place_of_birth') != null){
              $data['place_of_birth'] = $this->input->post('place_of_birth');
            }

            if ($this->input->post('sex') != null) {
                $data['sex']  = $this->input->post('sex');
            }

            if($this->input->post('religion') != null){
              $data['religion'] = $this->input->post('religion');
            }

            if($this->input->post('blood_group') != null){
              $data['blood_group'] = $this->input->post('blood_group');
            }

            if($this->input->post('nationality') != null){
              $data['nationality'] = $this->input->post('nationality');
            }

            if ($this->input->post('address') != null) {
               $data['address']        = $this->input->post('address');
            }

            if ($this->input->post('phone') != null) {
                $data['phone']          = $this->input->post('phone');
            }

            if ($this->input->post('dormitory_id') != null) {
               $data['dormitory_id']   = $this->input->post('dormitory_id');
            }
            if ($this->input->post('transport_id') != null) {
                $data['transport_id']   = $this->input->post('transport_id');
            }

            //$validation = email_validation_for_edit($data['email'], $param2, 'student');
            //if($validation == 1){

            $this->db->where('student_id', $param2);
            $this->db->update('student', $data);

            $data2['section_id'] = $this->input->post('section_id');

            if ($this->input->post('roll') != null) {
              $data2['roll'] = $this->input->post('roll');
            }
            else {
              $data2['roll'] = null;
            }

            $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
            $this->db->where('student_id' , $param2);
            $this->db->where('year' , $running_year);
            $this->db->update('enroll' , array(
                'section_id' => $data2['section_id'] , 'roll' => $data2['roll']
            ));

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param2 . '.jpg');
            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            redirect(base_url() . 'index.php?admin/student_information/' . $param3, 'refresh');

           }
          
    }

    function student_import($param1 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;

         if($param1 == 'import_excel')
          {
              $filename = $_FILES["file"]["tmp_name"];

              if($_FILES["file"]["size"] > 0)
                {
                  $file = fopen($filename, "r");
                   while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
                   {
                      $data = array(
                          'name'           => $importdata[0],
                          'other_name'     => $importdata[1],
                          'place_of_birth' => $importdata[2],
                          'nationality'    => $importdata[3],
                          'religion'       => $importdata[4],
                          'blood_group'    => $importdata[5],
                          'birthday'       => $importdata[6],
                          'password'       => sha1($importdata[7]),
                          'phone'          => $importdata[8],
                          'email'          => $importdata[9],
                          'address'        => $importdata[10],
                          'sex'            => $importdata[11],
                          );

                      $data['student_code'] = $this->generateStudentCode();

                      $this->db->insert('student', $data);
                      $student_id = $this->db->insert_id();

                      //insert record in enroll table
                      $data2['student_id']  = $student_id;

                        if($this->input->post('class_id') != null){
                            $data2['class_id'] = $this->input->post('class_id');
                        }

                        if ($this->input->post('section_id') != '') {
                            $data2['section_id'] = $this->input->post('section_id');
                        }

                        $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
                        $data2['year']           = $running_year;

                        $sessional_year = explode('-', $running_year);
                        $year = $sessional_year[0];

                        $rand_num = $this->generate_random_num();

                        $data2['enroll_code']   =   $year.'/'.$rand_num;

                        $this->db->insert('enroll', $data2);
                   }

                    fclose($file);

                    $this->session->set_flashdata('flash_message' , get_phrase('student_import_successful'));
                    redirect(base_url() . 'index.php?admin/student_information/' . $this->input->post('class_id'), 'refresh');                    
                    }else {
                        $this->session->set_flashdata('error_message', get_phrase('something_went_wrong'));
                    }
          }

          $page_data['page_name']  = 'student_import';
          $page_data['page_title'] = get_phrase('import_student_data');
          $this->load->view('backend/index', $page_data);
    }

    function generate_random_num()
    {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 4; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    function download($param1='') {

        if($param1 != '') {
        $fileName = basename($param1);
        $filePath = 'uploads/'.$fileName;

            if(!empty($fileName) && file_exists($filePath)){
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");

                // Read the file
                readfile($filePath);
                exit;
            }else{
                echo 'The file does not exist.';
            }

			return true;
        }
    }

    function delete_student($student_id = '', $class_id = '') {
      $this->crud_model->delete_student($student_id);
      $this->session->set_flashdata('flash_message' , get_phrase('student_deleted'));
      redirect(base_url() . 'index.php?admin/student_information/' . $class_id, 'refresh');
    }


    /**
     * @param string $param1
     * @param string $param2
     * Student Promotion
     */
    function student_promotion($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if($param1 == 'promote') {

            $running_year  =   $this->input->post('running_year');
            $from_class_id =   $this->input->post('promotion_from_class_id');

            $students_of_promotion_class =   $this->db->get_where('enroll' , array(
                'class_id' => $from_class_id , 'year' => $running_year
            ))->result_array();

            foreach($students_of_promotion_class as $row) {
                $enroll_data['enroll_code']     =   substr(md5(rand(0, 1000000)), 0, 7);
                $enroll_data['student_id']      =   $row['student_id'];
                $enroll_data['class_id']        =   $this->input->post('promotion_status_'.$row['student_id']);
                $enroll_data['year']            =   $this->input->post('promotion_year');
                $enroll_data['date_added']      =   strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('enroll' , $enroll_data);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('new_enrollment_successful'));
            redirect(base_url() . 'index.php?admin/student_promotion' , 'refresh');
        }

        $page_data['page_title']    = get_phrase('student_promotion');
        $page_data['page_name']  = 'student_promotion';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_to_promote($class_id_from , $class_id_to , $running_year , $promotion_year)
    {
        $page_data['class_id_from']     =   $class_id_from;
        $page_data['class_id_to']       =   $class_id_to;
        $page_data['running_year']      =   $running_year;
        $page_data['promotion_year']    =   $promotion_year;
        $this->load->view('backend/admin/student_promotion_selector' , $page_data);
    }


    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Manage parents class-wise
     */
    function parent($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {

            $data['name']   	= $this->input->post('name');
            $data['email']  	= $this->input->post('email');
            $data['username']	= $this->input->post('username');
            $data['password']   = sha1($this->input->post('password'));

            if ($this->input->post('phone') != null) {
               $data['phone'] = $this->input->post('phone');
            }

            if ($this->input->post('address') != null) {
               $data['address'] = $this->input->post('address');
            }

            if ($this->input->post('profession') != null) {
               $data['profession'] = $this->input->post('profession');
            }

            $validation = parent_username_validation($data['username']);
            if($validation == 1){

            $this->db->insert('parent', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            //$this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL

            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_username_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }

        if ($param1 == 'edit') {

            $data['name']                   = $this->input->post('name');
            $data['email']                  = $this->input->post('email');
            $data['username']       		= $this->input->post('username');

            if ($this->input->post('phone') != null) {
               $data['phone'] = $this->input->post('phone');
            }

            else{
              $data['phone'] = null;
            }

            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }

            else{
               $data['address'] = null;
            }

            if ($this->input->post('profession') != null) {
                $data['profession'] = $this->input->post('profession');
            }

            else{
                $data['profession'] = null;
            }

            $validation = parent_username_validation_for_edit($data['username'], $param2, 'parent');
            if ($validation == 1) {

            $this->db->where('parent_id' , $param2);
            $this->db->update('parent' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_username_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/parent/', 'refresh');
        }

        $page_data['page_title'] 	= get_phrase('all_parents');
        $page_data['page_name']  = 'parent';
        $this->load->view('backend/index', $page_data);
    }


    /****MANAGE TEACHERS*****/
    function teacher($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {

            $data['name']     = $this->input->post('name');
            $data['email']    = $this->input->post('email');
            $data['username']    = $this->input->post('username');
            $data['password'] = sha1($this->input->post('password'));

            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            if ($this->input->post('sex') != null) {
               $data['sex'] = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }
            if ($this->input->post('phone') != null) {
                $data['phone'] = $this->input->post('phone');
            }
            $validation = teacher_username_validation($data['username']);
            if($validation == 1){

                $this->db->insert('teacher', $data);
                $teacher_id = $this->db->insert_id();
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                //$this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_username_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            $data['username']    = $this->input->post('username');

            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            else{
              $data['birthday'] = null;
            }
            if ($this->input->post('sex') != null) {
                $data['sex']         = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address']     = $this->input->post('address');
            }
            else{
              $data['address'] = null;
            }
            if ($this->input->post('phone') != null) {
               $data['phone']       = $this->input->post('phone');
            }
            else{
              $data['phone'] = null;
            }
            $validation = teacher_username_validation_for_edit($data['username'], $param2, 'teacher');
            if($validation == 1){
                $this->db->where('teacher_id', $param2);
                $this->db->update('teacher', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_username_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        }
        else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('teacher', array(
                'teacher_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/teacher/', 'refresh');
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('manage_teacher');
        $this->load->view('backend/index', $page_data);
    }

    /** 
    Add Employee Bank Details
    **/
    function bank_details($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'add') {

            $data['staff_type'] = $this->input->post('staff_type');      //(e.g. teacher, accountant, etc)
            $data['staff_id']   = $this->input->post('staff_id');  //represents staff name
            $data['bank_id']    = $this->input->post('bank_id'); 
            $data['branch']     = $this->input->post('branch'); 
            $data['acct_no']    = $this->input->post('acct_no');          
           
            $this->db->insert('bank_details', $data);
            
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?admin/bank_details/', 'refresh');            
        }

        if ($param1 == 'do_update') {

            $data['bank_id']    = $this->input->post('bank_id'); 
            $data['branch']     = $this->input->post('branch'); 
            $data['acct_no']    = $this->input->post('acct_no');
           
            $this->db->where('id', $param2);
            $this->db->update('bank_details', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/bank_details/', 'refresh');            
        }

        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('bank_details', array(
                'id' => $param2
            ))->result_array();
        }

        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('bank_details');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/bank_details/', 'refresh');
        }

        $page_data['bank_details'] = $this->db->get('bank_details')->result_array();
        $page_data['page_name']    = 'bank_details';
        $page_data['page_title']   = get_phrase('staff_bank_details');
        $this->load->view('backend/index', $page_data);

    }

    /** MANAGE EMPLOYEE **/
    function employee($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {

            $data['name']        = $this->input->post('name');
            $data['other_name']  = $this->input->post('other_name');
            $data['email']       = $this->input->post('email'); 
            $data['state_id']    = $this->input->post('state_id'); 
            $data['local_id']    = $this->input->post('local_id');            

            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            if ($this->input->post('sex') != null) {
               $data['sex'] = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }
            if ($this->input->post('phone') != null) {
                $data['phone'] = $this->input->post('phone');
            }
            if ($this->input->post('designation') != null) {
                $data['designation'] = $this->input->post('designation');
            }
            if ($this->input->post('working_hour') != null) {
                $data['working_hour'] = $this->input->post('working_hour');
            }
            if ($this->input->post('nationality') != null) {
                $data['nationality'] = $this->input->post('nationality');
            }
            if ($this->input->post('religion') != null) {
                $data['religion'] = $this->input->post('religion');
            }

            $data['emp_code'] = $this->generateEmployeeCode();

            $this->db->insert('employee', $data);
            $emp_id = $this->db->insert_id();

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/employee_image/' . $emp_id . '.jpg');

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?admin/employee/', 'refresh');            
        }

        if ($param1 == 'do_update') {

            $data['name']        = $this->input->post('name');
            $data['other_name']  = $this->input->post('other_name');
            $data['email']       = $this->input->post('email'); 
            $data['state_id']    = $this->input->post('state_id'); 
            $data['local_id']    = $this->input->post('local_id');  

            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            else{
              $data['birthday'] = null;
            }
            if ($this->input->post('sex') != null) {
                $data['sex']         = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address']     = $this->input->post('address');
            }
            else{
              $data['address'] = null;
            }
            if ($this->input->post('phone') != null) {
               $data['phone']       = $this->input->post('phone');
            }
            else{
              $data['phone'] = null;
            }
            if ($this->input->post('designation') != null) {
               $data['designation']       = $this->input->post('designation');
            }
            else{
              $data['designation'] = null;
            }
            if ($this->input->post('working_hour') != null) {
               $data['working_hour']       = $this->input->post('working_hour');
            }
            else{
              $data['working_hour'] = null;
            }
            if ($this->input->post('nationality') != null) {
               $data['nationality']       = $this->input->post('nationality');
            }
            else{
              $data['nationality'] = null;
            }
            if ($this->input->post('religion') != null) {
               $data['religion']       = $this->input->post('religion');
            }
            else{
              $data['religion'] = null;
            }

            $this->db->where('emp_id', $param2);
            $this->db->update('employee', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/employee_image/' . $param2 . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            redirect(base_url() . 'index.php?admin/employee/', 'refresh');            
        }

        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('employee', array(
                'emp_id' => $param2
            ))->result_array();
        }

        if ($param1 == 'delete') {
            $this->db->where('emp_id', $param2);
            $this->db->delete('employee');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/employee/', 'refresh');
        }

        $page_data['employees']  = $this->db->get('employee')->result_array();
        $page_data['page_name']  = 'employee';
        $page_data['page_title'] = get_phrase('manage_employee');
        $this->load->view('backend/index', $page_data);

    }

    /** 
    IMPORT EMPLOYEE CSV
    **/
    function employee_import($param1 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

         if($param1 == 'import_excel')
          {
              $filename = $_FILES["file"]["tmp_name"];

              if($_FILES["file"]["size"] > 0)
                {
                  $file = fopen($filename, "r");
                   while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
                   {
                          $data = array(
                              'name'        => $importdata[0],
                              'other_name'  => $importdata[1],
                              'birthday'    => $importdata[2],
                              'sex'         => $importdata[3],
                              'nationality' => $importdata[4],                              
                              'religion'    => $importdata[5],                              
                              'address'     => $importdata[6],
                              'phone'       => $importdata[7],
                              'email'       => $importdata[8],
                                               
                              );    

                          $data['emp_code'] = $this->generateEmployeeCode();

                          $this->db->insert('employee', $data);                         
                   }

                    fclose($file);

                    $this->session->set_flashdata('flash_message' , get_phrase('employee_import_successful'));
                    redirect(base_url() . 'index.php?admin/employee', 'refresh');                    
                    }else {
                        $this->session->set_flashdata('error_message', get_phrase('something_went_wrong'));
                    }
          }

          $page_data['page_name']  = 'employee_import';
          $page_data['page_title'] = get_phrase('import_employee_data');
          $this->load->view('backend/index', $page_data);
    }


    /**Import teachers records csv**/
    function teacher_import($param1 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

         if($param1 == 'import_excel')
          {
              $filename = $_FILES["file"]["tmp_name"];

              if($_FILES["file"]["size"] > 0)
                {
                  $file = fopen($filename, "r");
                   while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE)
                   {
                          $data = array(
                              'name'        => $importdata[0],                              
                              'birthday'    => $importdata[1],
                              'sex'         => $importdata[2],
                              'religion'    => $importdata[3],
                              'blood_group' => $importdata[4],                              
                              'address'     => $importdata[5],
                              'phone'       => $importdata[6],
                              'email'       => $importdata[7],
                              'password'    => sha1($importdata[8]),
                                               
                              );    

                          $data['teacher_code'] = $this->generateTeacherCode();

                          $this->db->insert('teacher', $data);                         
                   }

                    fclose($file);

                    $this->session->set_flashdata('flash_message' , get_phrase('teacher_import_successful'));
                    redirect(base_url() . 'index.php?admin/teacher', 'refresh');                    
                    }else {
                        $this->session->set_flashdata('error_message', get_phrase('something_went_wrong'));
                    }
          }

          $page_data['page_name']  = 'teacher_import';
          $page_data['page_title'] = get_phrase('import_teacher_data');
          $this->load->view('backend/index', $page_data);
    }

    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('teacher_id') != null) {
                $data['teacher_id'] = $this->input->post('teacher_id');
            }

            $this->db->insert('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/subject/'.$data['class_id'], 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/subject/'.$data['class_id'], 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/subject/'.$param3, 'refresh');
        }
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
		    $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1, 'year' => $running_year))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE CLASSES*****/
    function classes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            $data['teacher_id']   = $this->input->post('teacher_id');
            if ($this->input->post('name_numeric') != null) {
                $data['name_numeric'] = $this->input->post('name_numeric');
            }

            $this->db->insert('class', $data);
            $class_id = $this->db->insert_id();
            //create a section by default
            $data2['class_id']  =   $class_id;
            $data2['name']      =   'A';
            $data2['teacher_id']=$data['teacher_id'];
            $this->db->insert('section' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            $data['teacher_id']   = $this->input->post('teacher_id');
            if ($this->input->post('name_numeric') != null) {
                $data['name_numeric'] = $this->input->post('name_numeric');
            }
            else{
               $data['name_numeric'] = null;
            }
            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/classes/', 'refresh');
        }
        $page_data['classes']    = $this->db->get('class')->result_array();
        $page_data['page_name']  = 'class';
        $page_data['page_title'] = get_phrase('manage_class');
        $this->load->view('backend/index', $page_data);
    }


     function get_subject($class_id)
    {
        $subject = $this->db->get_where('subject' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        // detect the first class
        if ($class_id == '')
            $class_id           =   $this->db->get('class')->first_row()->class_id;

        $page_data['page_name']  = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('academic_syllabus');
        $page_data['class_id']   = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function upload_academic_syllabus()
    {
        $data['academic_syllabus_code'] =   substr(md5(rand(0, 1000000)), 0, 7);
        if ($this->input->post('description') != null) {
           $data['description'] = $this->input->post('description');
        }
        $data['title']                  =   $this->input->post('title');
        $data['class_id']               =   $this->input->post('class_id');
        $data['subject_id']             =   $this->input->post('subject_id');
        $data['uploader_type']          =   $this->session->userdata('login_type');
        $data['uploader_id']            =   $this->session->userdata('login_user_id');
        $data['year']                   =   $this->db->get_where('settings',array('type'=>'running_year'))->row()->description;
        $data['timestamp']              =   strtotime(date("Y-m-d H:i:s"));
        //uploading file using codeigniter upload library
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path']   =  'uploads/syllabus/';
        $config['allowed_types'] =  '*';
        $_FILES['file_name']['name']     = $files['name'];
        $_FILES['file_name']['type']     = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size']     = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');

        $data['file_name'] = $_FILES['file_name']['name'];

        $this->db->insert('academic_syllabus', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('syllabus_uploaded'));
        redirect(base_url() . 'index.php?admin/academic_syllabus/' . $data['class_id'] , 'refresh');

    }

    function download_academic_syllabus($academic_syllabus_code)
    {
        $file_name = $this->db->get_where('academic_syllabus', array(
            'academic_syllabus_code' => $academic_syllabus_code
        ))->row()->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
    }

    function delete_academic_syllabus($academic_syllabus_code) {
      $file_name = $this->db->get_where('academic_syllabus', array(
          'academic_syllabus_code' => $academic_syllabus_code
      ))->row()->file_name;
      if (file_exists('uploads/syllabus/'.$file_name)) {
        unlink('uploads/syllabus/'.$file_name);
      }
      $this->db->where('academic_syllabus_code', $academic_syllabus_code);
      $this->db->delete('academic_syllabus');

      $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
      redirect(base_url() . 'index.php?admin/academic_syllabus' , 'refresh');

    }

    /****MANAGE SECTIONS*****/
    function section($class_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        // detect the first class
        if ($class_id == '')
            $class_id           =   $this->db->get('class')->first_row()->class_id;

        $page_data['page_name']  = 'section';
        $page_data['page_title'] = get_phrase('manage_sections');
        $page_data['class_id']   = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function sections($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       =   $this->input->post('name');
            $data['class_id']   =   $this->input->post('class_id');
            $data['teacher_id'] =   $this->input->post('teacher_id');
            if ($this->input->post('nick_name') != null) {
               $data['nick_name'] = $this->input->post('nick_name');
            }
            $validation = duplication_of_section_on_create($data['class_id'], $data['name']);
            if($validation == 1){
                $this->db->insert('section' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('duplicate_name_of_section_is_not_allowed'));
            }

            redirect(base_url() . 'index.php?admin/section/' . $data['class_id'] , 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']       =   $this->input->post('name');
            $data['class_id']   =   $this->input->post('class_id');
            $data['teacher_id'] =   $this->input->post('teacher_id');
            if ($this->input->post('nick_name') != null) {
                $data['nick_name'] = $this->input->post('nick_name');
            }
            else{
                $data['nick_name'] = null;
            }
            $validation = duplication_of_section_on_edit($param2, $data['class_id'], $data['name']);
            if ($validation == 1) {
               $this->db->where('section_id' , $param2);
               $this->db->update('section' , $data);
               $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
               $this->session->set_flashdata('error_message' , get_phrase('duplicate_name_of_section_is_not_allowed'));
            }

            redirect(base_url() . 'index.php?admin/section/' . $data['class_id'] , 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('section_id' , $param2);
            $this->db->delete('section');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/section' , 'refresh');
        }
    }

    function get_class_section($class_id)
    {
        $sections = $this->db->get_where('section' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_lga($state_id)
    {
        $sections = $this->db->get_where('locals' , array(
            'state_id' => $state_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['local_id'] . '">' . $row['local_name'] . '</option>';
        }
    }

    function get_class_subject($class_id)
    {
        $subjects = $this->db->get_where('subject' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($subjects as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_students($class_id)
    {
        /*$students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();

        foreach ($students as $row) {
            $name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
            $other_name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->other_name;
            echo '<option value="' . $row['student_id'] . '">' . $name . '&nbsp;' . $other_name .'</option>';
        }*/

        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        $this->db->select('student.name, student.student_code, enroll.roll, enroll.enroll_code, enroll.student_id');
        $this->db->from('student');
        $this->db->where('enroll.class_id', $class_id);
        $this->db->where('enroll.year', $running_year);
        $this->db->join('enroll', 'enroll.student_id = student.student_id');
        $this->db->order_by('student.name', 'ASC');
        $students = $this->db->get()->result_array();

        foreach ($students as $row) {
            echo '<option value="' . $row['student_id'] . '">' . $row['name'] . '&nbsp;' . $row['other_name'] .'</option>';
        }
    }

    function get_class_students_mass($class_id)
    {
        $students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        echo '<div class="form-group">
                <label class="col-sm-3 control-label">' . get_phrase('students') . '</label>
                <div class="col-sm-9">';
        foreach ($students as $row) {
             $name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
            echo '<div class="checkbox">
                    <label><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name .'</label>
                </div>';
        }
        echo '<br><button type="button" class="btn btn-default" onClick="select()">'.get_phrase('select_all').'</button>';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()"> '.get_phrase('select_none').' </button>';
        echo '</div></div>';
    }

    function get_staff_names($type_id)
    {
        if($type_id == 'teacher') {
            $names = $this->db->get('teacher')->result_array();
            foreach ($names as $row) {
                echo '<option value="' . $row['teacher_id'] . '">' . $row['name'] . '</option>';
            }
        }

         if($type_id == 'accountant') {
            $names = $this->db->get('accountant')->result_array();
            foreach ($names as $row) {
                echo '<option value="' . $row['accountant_id'] . '">' . $row['name'] . '</option>';
            }
        }

         if($type_id == 'librarian') {
            $names = $this->db->get('librarian')->result_array();
            foreach ($names as $row) {
                echo '<option value="' . $row['librarian_id'] . '">' . $row['name'] . '</option>';
            }
        }

         if($type_id == 'employee') {
            $names = $this->db->get('employee')->result_array();
            foreach ($names as $row) {
                echo '<option value="' . $row['emp_id'] . '">' . $row['name'] . '</option>';
            }
        }
        
    }



    /****MANAGE EXAMS*****/
    function exam($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            $data['year']    = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            $this->db->insert('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/exam/', 'refresh');
        }
        if ($param1 == 'edit' && $param2 == 'do_update') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            else{
              $data['comment'] = null;
            }
            $data['year']    = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $this->db->where('exam_id', $param3);
            $this->db->update('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/exam/', 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('exam', array(
                'exam_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('exam_id', $param2);
            $this->db->delete('exam');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/exam/', 'refresh');
        }
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['exams']      = $this->db->get_where('exam', array('year' => $running_year))->result_array();
        $page_data['page_name']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_exam');
        $this->load->view('backend/index', $page_data);
    }

    /****** SEND EXAM MARKS VIA SMS ********/
    function exam_marks_sms($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_sms') {

            $exam_id    =   $this->input->post('exam_id');
            $class_id   =   $this->input->post('class_id');
            $receiver   =   $this->input->post('receiver');

            if ($exam_id != '' && $class_id != '' && $receiver != '') {

            // get all the students of the selected class
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $class_id,
                    'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
            ))->result_array();

            // get the marks of the student for selected exam
            foreach ($students as $row) {

                if ($receiver == 'student')
                    $receiver_phone = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;
                if ($receiver == 'parent') {
                    $parent_id =  $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                    if($parent_id != '' || $parent_id != null) {
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        if($receiver_phone == null){
                          $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                        }
                    }
                }

                $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                $this->db->where('exam_id' , $exam_id);
                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('year', $running_year);
                $marks = $this->db->get('mark')->result_array();

                $message = '';
                foreach ($marks as $row2) {
                    $stud_name = $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->name;
                    $subject       = $this->db->get_where('subject' , array('subject_id' => $row2['subject_id']))->row()->name;
                    $mark_obtained = $row2['mark_obtained'];
                    $message      .= $stud_name . '&nbsp;'. $subject . ' : ' . $mark_obtained . ' , ';

                }
                // send sms
                $this->sms_model->send_sms( $message , $receiver_phone );
            }
            $this->session->set_flashdata('flash_message' , get_phrase('message_sent'));
          }
          else{
            $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
          }
            redirect(base_url() . 'index.php?admin/exam_marks_sms' , 'refresh');
        }

        $page_data['page_name']  = 'exam_marks_sms';
        $page_data['page_title'] = get_phrase('send_marks_by_sms');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE EXAM MARKS*****/
    function marks2($exam_id = '', $class_id = '', $subject_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['subject_id'] = $this->input->post('subject_id');

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'index.php?admin/marks2/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'index.php?admin/marks2/', 'refresh');
            }
        }
        if ($this->input->post('operation') == 'update') {

            $running_year    = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'year' => $running_year))->result_array();
            foreach($students as $row) {
                $data['mark_obtained'] = $this->input->post('mark_obtained_' . $row['student_id']);
                $data['comment']       = $this->input->post('comment_' . $row['student_id']);

                $this->db->where('mark_id', $this->input->post('mark_id_' . $row['student_id']));
                $this->db->update('mark', array('mark_obtained' => $data['mark_obtained'] , 'comment' => $data['comment']));
            }
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/marks2/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['subject_id'] = $subject_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'marks2';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_selector()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

        if($data['class_id'] != '' && $data['exam_id'] != '') {

        $query = $this->db->get_where('mark' , array(
                    'exam_id' => $data['exam_id'],
                        'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                                'subject_id' => $data['subject_id'],
                                    'year' => $data['year']
                ));
        if($query->num_rows() < 1) {

            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();

            foreach($students as $row) {
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
            }
        }else {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();

            foreach($students as $row) {

                $data['student_id'] = $row['student_id'];

                // check if a student exists with another section id
                // for that particular exam and subject, if it does update the section id to the new one
                $query2 = $this->db->get_where('mark', array(
                    'student_id' => $row['student_id'], 'exam_id' => $data['exam_id'], 'subject_id' => $data['subject_id'], 'year' => $data['year']
                ));

                if ($query2->num_rows() < 1) {
                    $this->db->insert('mark', $data);
                } else {

                    $section_id_in_mark = $this->db->get_where('mark', array(
                        'student_id' => $row['student_id'], 'exam_id' => $data['exam_id'], 'subject_id' => $data['subject_id'], 'year' => $data['year']
                    ))->row()->section_id;

                    $section_id_in_enroll = $this->db->get_where('enroll', array(
                        'class_id' => $data['class_id'], 'student_id' => $row['student_id'], 'year' => $data['year']
                    ))->row()->section_id;

                    if ($section_id_in_mark != $section_id_in_enroll) {
                        $updateData = array(
                            'section_id' => $row['section_id']
                        );
                        $this->db->where('student_id', $row['student_id']);
                        $this->db->update('mark', $updateData);
                    }
                }
            }
        }
        redirect(base_url() . 'index.php?admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'] , 'refresh');
        //echo 'procced da fuck';
    }
    else{
        $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }
}

    function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
            if ($class_id != '' && $exam_id != '') {

            $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $marks_of_students = $this->db->get_where('mark' , array(
                'exam_id' => $exam_id,
                    'class_id' => $class_id,
                        'section_id' => $section_id,
                            'year' => $running_year,
                                'subject_id' => $subject_id
            ))->result_array();

            foreach($marks_of_students as $row) {

                $other_mark     = $this->input->post('other_mark_'.$row['mark_id']);
                $mark_test_1    = $this->input->post('mark_test_1_'.$row['mark_id']);
                $mark_test_2    = $this->input->post('mark_test_2_'.$row['mark_id']);
                $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
                $total_score    = $other_mark + $mark_test_1 + $mark_test_2 + $obtained_marks;
                $comment        = $this->input->post('comment_'.$row['mark_id']);

                if($total_score > 100) {
                    $this->session->set_flashdata('error_message' , get_phrase('Total score must not be greater than 100, please check your inputs'));
                    redirect(base_url().'index.php?admin/marks_manage_view/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id , 'refresh');
                }else{
                    $this->db->where('mark_id' , $row['mark_id']);
                    $this->db->update('mark' , array('other_mark' => $other_mark, 'mark_test_1' => $mark_test_1, 'mark_test_2' => $mark_test_2, 'mark_obtained' => $obtained_marks , 'total_score' => $total_score , 'comment' => $comment));
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('marks_updated'));
            redirect(base_url().'index.php?admin/marks_manage_view/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id , 'refresh');
        }
        else{
            $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
            $page_data['page_name']  =   'marks_manage';
            $page_data['page_title'] = get_phrase('manage_exam_marks');
            $this->load->view('backend/index', $page_data);
        }
    }

    function marks_get_subject($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/marks_get_subject' , $page_data);
    }

    /**
     * @param string $class_id
     * @param string $exam_id
     * @param string $section_id
     * Submit Term Result
     */
    function submit_term_result($class_id = '' , $exam_id = '', $section_id = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['section_id'] = $this->input->post('section_id');
            $page_data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) {

                $query = $this->db->get_where('result' , array(
                    'exam_id'    => $page_data['exam_id'],
                    'class_id'   => $page_data['class_id'],
                    'section_id' => $page_data['section_id'],
                    'year'       => $page_data['year']
                ));

                if($query->num_rows() < 1) {
                    $students = $this->db->get_where('enroll' , array(
                        'class_id' => $page_data['class_id'] , 'section_id' => $page_data['section_id'] , 'year' => $page_data['year']
                    ))->result_array();
                    foreach($students as $row) {
                        $page_data['student_id'] = $row['student_id'];
                        $this->db->insert('result' , $page_data);
                    }
                }
                redirect(base_url() . 'index.php?admin/submit_term_result/' . $page_data['class_id'] . '/' . $page_data['exam_id'] . '/' . $page_data['section_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class and exam');
                redirect(base_url() . 'index.php?admin/submit_term_result/', 'refresh');
            }
        }

        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['section_id'] = $section_id;

        $page_data['page_info'] = 'Submit Term Result';

        $page_data['page_name']  = 'submit_term_result';
        $page_data['page_title'] = get_phrase('submit_term_result');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $class_id
     * @param string $exam_id
     * @param string $section_id
     * Auto-Submit all term results
     */
    function submit_all_term_result($class_id = '' , $exam_id = '', $section_id = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $subjects     = $this->db->get_where('subject' , array('class_id' => $class_id, 'year' => $running_year))->result_array();
        $students     = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year))->result_array();

        foreach($students as $row) {

            $total_marks = 0;
            $total_grade_point = 0;
            foreach($subjects as $row2) {

                $obtained_mark_query = 	$this->db->get_where('mark' , array(
                    'class_id'   => $class_id,
                    'exam_id'    => $exam_id,
                    'section_id' => $section_id,
                    'subject_id' => $row2['subject_id'],
                    'student_id' => $row['student_id'],
                    'year'       => $running_year
                ));

                if ( $obtained_mark_query->num_rows() > 0) {
                    $total_score = $obtained_mark_query->row()->total_score;
                    if ($total_score >= 0 && $total_score != '') {
                        $grade = $this->crud_model->get_grade($total_score);
                        $total_grade_point += $grade['grade_point'];
                        $stu_grade = $grade['grade_point'];
                    }
                    $total_marks += $total_score;
                }
            }

            $class_array = array('14', '15');   //class_id for SS2 and SS3

            if(in_array($class_id, $class_array)) {

                /**
                 * For SS2 and above
                 * On entering records, we skip the subject the student is not offering
                 * Upon computation, any student that has a blank record (skipped record or zero for total_score entry) for a subject,
                 * that record is counted for that student as "Not being offered"
                 * Average = Total Scores Obtained [$total_marks] / No. of Subjects Offered by student [$number_of_subjects]
                 */
                $this->db->where('class_id' , $class_id);
                $this->db->where('exam_id' , $exam_id);
                $this->db->where('section_id' , $section_id);
                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('year' , $running_year);
                $this->db->where('total_score != ', 0, FALSE);
                $this->db->from('mark');
                $number_of_subjects = $this->db->count_all_results();
                $average = ($total_marks / $number_of_subjects);

            } else {

                /**
                 * For SS1 and below
                 * On entering records, compute all subjects offered in the class
                 * Average = Total Scores Obtained [total_marks] / total no. of subjects in class
                 */

                $this->db->where('class_id' , $class_id);
                $this->db->where('year' , $running_year);
                $this->db->from('subject');
                $number_of_subjects = $this->db->count_all_results();
                $average = ($total_marks / $number_of_subjects);
            }


            /**
             * Update the result table
             * with new values for total_mark and average
             */
            $this->db->where('class_id', $class_id);
            $this->db->where('exam_id', $exam_id);
            $this->db->where('section_id', $section_id);
            $this->db->where('year', $running_year);
            $this->db->where('student_id', $row['student_id']);
            $this->db->update('result', array('withdrawn' => '1', 'total_mark' => $total_marks, 'average' => $average));
        }

        //echo 'success';
        $this->session->set_flashdata('flash_message' , 'Result(s) Submitted Successfully');
        redirect(base_url().'index.php?admin/submit_term_result/'.$class_id.'/'.$exam_id.'/'.$section_id, 'refresh');
    }

    /**
     * @param string $class_id
     * @param string $exam_id
     * @param string $section_id
     * Auto-withdraw all term result
     */
    function withdraw_all_term_result($class_id = '' , $exam_id = '', $section_id = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $subjects     = $this->db->get_where('subject' , array('class_id' => $class_id, 'year' => $running_year))->result_array();
        $students     = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year))->result_array();

        foreach($students as $row) {

            $total_marks = 0;
            $total_grade_point = 0;
            foreach($subjects as $row2) {

                $obtained_mark_query = 	$this->db->get_where('mark' , array(
                    'class_id'   => $class_id,
                    'exam_id'    => $exam_id,
                    'section_id' => $section_id,
                    'subject_id' => $row2['subject_id'] ,
                    'student_id' => $row['student_id'],
                    'year'       => $running_year
                ));

                if ( $obtained_mark_query->num_rows() > 0) {
                    $total_score = $obtained_mark_query->row()->total_score;
                    if ($total_score >= 0 && $total_score != '') {
                        $grade = $this->crud_model->get_grade($total_score);
                        $total_grade_point += $grade['grade_point'];
                        $stu_grade = $grade['grade_point'];
                    }
                    $total_marks += $total_score;
                }
            }

            $class_array = array('14', '15');   //class_id for SS2 and SS3

            if(in_array($class_id, $class_array)) {

                /**
                 * For SS2 and above
                 * On entering records, we skip the subject the student is not offering
                 * Upon computation, any student that has a blank record (skipped record or zero for total_score entry) for a subject,
                 * that record is counted for that student as "Not being offered"
                 * Average = Total Scores Obtained [$total_marks] / No. of Subjects Offered by student [$number_of_subjects]
                 */
                $this->db->where('class_id' , $class_id);
                $this->db->where('exam_id' , $exam_id);
                $this->db->where('section_id' , $section_id);
                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('year' , $running_year);
                $this->db->where('total_score != ', 0, FALSE);
                $this->db->from('mark');
                $number_of_subjects = $this->db->count_all_results();
                $average = ($total_marks / $number_of_subjects);

            } else {

                /**
                 * For SS1 and below
                 * On entering records, compute all subjects offered in the class
                 * Average = Total Scores Obtained [total_marks] / total no. of subjects in class
                 */

                $this->db->where('class_id' , $class_id);
                $this->db->where('year' , $running_year);
                $this->db->from('subject');
                $number_of_subjects = $this->db->count_all_results();
                $average = ($total_marks / $number_of_subjects);
            }

            /**
             * Update the result table
             * with new values for total_mark and average
             */
            $this->db->where('class_id', $class_id);
            $this->db->where('exam_id', $exam_id);
            $this->db->where('section_id' , $section_id);
            $this->db->where('year', $running_year);
            $this->db->where('student_id', $row['student_id']);
            $this->db->update('result' , array('withdrawn' => '0', 'total_mark' => $total_marks, 'average' => $average));
        }

        //echo 'success';
        $this->session->set_flashdata('flash_message' , 'Result(s) Withdrawn Successfully');
        redirect(base_url().'index.php?admin/submit_term_result/'.$class_id.'/'.$exam_id.'/'.$section_id, 'refresh');
    }

    function submit_result(){

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if(!empty($_POST['class_id']) && !empty($_POST['exam_id']) && !empty($_POST['student_id']) && ($_POST['type'] != '' && $_POST['total_mark'] != '' && $_POST['average'] != ''))
        {
            $data['year']         = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $data['class_id']     = $_POST['class_id'];
            $data['exam_id']      = $_POST['exam_id'];
            $data['section_id']   = $_POST['section_id'];
            $data['student_id']   = $_POST['student_id'];
            $data['total_mark']   = $_POST['total_mark'];
            $data['average']      = $_POST['average'];

            if($_POST['type'] == 0)
            {
                $query = $this->db->get_where('result', array('student_id' => $data['student_id'], 'exam_id' => $data['exam_id'], 'section_id' => $data['section_id'], 'class_id' => $data['class_id'], 'year' => $data['year']))->row_array();

                if($query > 0) {
                    $this->db->where('class_id', $data['class_id']);
                    $this->db->where('exam_id', $data['exam_id']);
                    $this->db->where('year', $data['year']);
                    $this->db->where('student_id', $data['student_id']);
                    $this->db->update('result' , array('withdrawn' => '1', 'total_mark' => $data['total_mark'], 'average' => $data['average']));

                    echo '<div id="button_'.$data['student_id'].'"><a href="javascript:;" class="btn btn-sm btn-warning" onclick="submit_result('.$data['class_id'].', '.$data['exam_id'].', '.$data['section_id'].', '.$data['student_id'].', '.$data['total_mark'].', '.$data['average'].', 1)">Withdraw Result</a></div>';
                } else {
                    $data['withdrawn'] = '1';
                    $this->db->insert('result' , $data);

                    echo '<div id="button_'.$data['student_id'].'"><a href="javascript:;" class="btn btn-sm btn-warning" onclick="submit_result('.$data['class_id'].', '.$data['exam_id'].', '.$data['section_id'].', '.$data['student_id'].', '.$data['total_mark'].', '.$data['average'].', 1)">Withdraw Result</a></div>';
                }

            }else{

                $this->db->where('class_id', $data['class_id']);
                $this->db->where('exam_id', $data['exam_id']);
                $this->db->where('year', $data['year']);
                $this->db->where('student_id', $data['student_id']);
                $this->db->update('result' , array('withdrawn' => '0'));

                echo '<div id="button_'.$data['student_id'].'"><a href="javascript:;" class="btn btn-sm btn-success" onclick="submit_result('.$data['class_id'].', '.$data['exam_id'].', '.$data['section_id'].', '.$data['student_id'].', '.$data['total_mark'].', '.$data['average'].', 0)">Submit Result</a></div>';
            }
        }
    }

    function submit_get_section($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/submit_get_section' , $page_data);
    }

    /**
     * @param string $class_id
     * @param string $exam_id
     * @param string $section_id
     * Tabulation Sheet
     */
    function tabulation_sheet($class_id = '' , $exam_id = '', $section_id = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['section_id'] = $this->input->post('section_id');

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(base_url() . 'index.php?admin/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id'] . '/'. $page_data['section_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class and exam');
                redirect(base_url() . 'index.php?admin/tabulation_sheet/', 'refresh');
            }
        }

        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
        $page_data['section_id'] = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'tabulation_sheet';
        $page_data['page_title'] = get_phrase('tabulation_sheet');
        $this->load->view('backend/index', $page_data);

    }

    function tabulation_sheet_print_view($class_id , $exam_id, $section_id) {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['class_id']    = $class_id;
        $page_data['exam_id']     = $exam_id;
        $page_data['section_id']  = $section_id;

        $this->load->view('backend/admin/tabulation_sheet_print_view' , $page_data);
    }

    function mark_sheet_print_view($class_id , $exam_id, $section_id, $subject_id) {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['class_id']    = $class_id;
        $page_data['exam_id']     = $exam_id;
        $page_data['section_id']  = $section_id;
        $page_data['subject_id']  = $subject_id;

        $this->load->view('backend/admin/mark_sheet_print_view' , $page_data);

    }


    /****MANAGE GRADES*****/
    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }

            $this->db->insert('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            else{
              $data['comment'] = null;
            }

            $this->db->where('grade_id', $param2);
            $this->db->update('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('grade', array(
                'grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/grade/', 'refresh');
        }
        $page_data['grades']     = $this->db->get('grade')->result_array();
        $page_data['page_name']  = 'grade';
        $page_data['page_title'] = get_phrase('manage_grade');
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {

            if($this->input->post('class_id') != null){
               $data['class_id']       = $this->input->post('class_id');
            }

            $data['section_id']     = $this->input->post('section_id');
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            // checking duplication
            $array = array(
               'section_id'    => $data['section_id'],
               'class_id'      => $data['class_id'],
               'time_start'    => $data['time_start'],
               'time_end'      => $data['time_end'],
               'time_start_min'=> $data['time_start_min'],
               'time_end_min'  => $data['time_end_min'],
               'day'           => $data['day'],
               'year'          => $data['year']
            );
            $validation = duplication_of_class_routine_on_create($array);
            if ($validation == 1) {
                $this->db->insert('class_routine', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('time_conflicts'));
            }

            redirect(base_url() . 'index.php?admin/class_routine_add/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['class_id']       = $this->input->post('class_id');
            if($this->input->post('section_id') != '') {
                $data['section_id'] = $this->input->post('section_id');
            }
            $data['subject_id']     = $this->input->post('subject_id');
            $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['subject_id'] != '') {
            // checking duplication
            $array = array(
               'section_id'    => $data['section_id'],
               'class_id'      => $data['class_id'],
               'time_start'    => $data['time_start'],
               'time_end'      => $data['time_end'],
               'time_start_min'=> $data['time_start_min'],
               'time_end_min'  => $data['time_end_min'],
               'day'           => $data['day'],
               'year'          => $data['year']
            );
            $validation = duplication_of_class_routine_on_edit($array, $param2);

            if ($validation == 1) {
                $this->db->where('class_routine_id', $param2);
                $this->db->update('class_routine', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('time_conflicts'));
            }
          }
          else{
            $this->session->set_flashdata('error_message' , get_phrase('subject_is_not_found'));
          }

            redirect(base_url() . 'index.php?admin/class_routine_view/' . $data['class_id'], 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class_routine', array(
                'class_routine_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $class_id = $this->db->get_where('class_routine' , array('class_routine_id' => $param2))->row()->class_id;
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/class_routine_view/' . $class_id, 'refresh');
        }

    }

    function class_routine_add()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'class_routine_add';
        $page_data['page_title'] = get_phrase('add_class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_view($class_id)
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'class_routine_view';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/admin/class_routine_print_view' , $page_data);
    }

    function get_class_section_subject($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/class_routine_section_subject_selector' , $page_data);
    }

    function section_subject_edit($class_id , $class_routine_id)
    {
        $page_data['class_id']          =   $class_id;
        $page_data['class_routine_id']  =   $class_routine_id;
        $this->load->view('backend/admin/class_routine_section_subject_edit' , $page_data);
    }

    function manage_attendance()
    {
        if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $page_data['page_name']  =  'manage_attendance';
        $page_data['page_title'] =  get_phrase('manage_attendance_of_class');
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $timestamp = '')
    {
        if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;

        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'manage_attendance_view';

        $section_name = $this->db->get_where('section' , array(
            'section_id' => $section_id
        ))->row()->name;

        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
    }

    function get_section($class_id) {
          $page_data['class_id'] = $class_id;
          $this->load->view('backend/admin/manage_attendance_section_holder' , $page_data);
    }

    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['timestamp']  = strtotime($this->input->post('timestamp'));
        $data['section_id'] = $this->input->post('section_id');
        $query = $this->db->get_where('attendance' ,array(
            'class_id'=>$data['class_id'],
                'section_id'=>$data['section_id'],
                    'year'=>$data['year'],
                        'timestamp'=>$data['timestamp']
        ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();

            foreach($students as $row) {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $this->db->insert('attendance' , $attn_data);
            }

        }
        redirect(base_url().'index.php?admin/manage_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['timestamp'],'refresh');
    }

    function attendance_update($class_id = '' , $section_id = '' , $timestamp = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;

        $attendance_of_students = $this->db->get_where('attendance' , array(
            'class_id'=>$class_id,'section_id'=>$section_id,'year'=>$running_year,'timestamp'=>$timestamp
        ))->result_array();

        foreach($attendance_of_students as $row) {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));

            if ($attendance_status == 2) {

                if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                    $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                    $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                    $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                    if($parent_id != null && $parent_id != 0){
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        if($receiver_phone != '' || $receiver_phone != null){
                            $this->sms_model->send_sms($message,$receiver_phone);
                        }
                        else{
                            $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                        }
                    }
                    else{
                        $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                    }
                }
            }
        }

        $this->session->set_flashdata('flash_message' , get_phrase('attendance_updated'));
        redirect(base_url().'index.php?admin/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$timestamp , 'refresh');
    }

	/****** DAILY ATTENDANCE *****************/
	function manage_attendance2($date='',$month='',$year='',$class_id='' , $section_id = '' , $session = '')
	{
		if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;


		if($_POST)
		{
			// Loop all the students of $class_id
            $this->db->where('class_id' , $class_id);
            if($section_id != '') {
                $this->db->where('section_id' , $section_id);
            }
            //$session = base64_decode( urldecode( $session ) );
            $this->db->where('year' , $session);
            $students = $this->db->get('enroll')->result_array();
            foreach ($students as $row)
            {
                $attendance_status  =   $this->input->post('status_' . $row['student_id']);

                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('date' , $date);
                $this->db->where('year' , $year);
                $this->db->where('class_id' , $row['class_id']);
                if($row['section_id'] != '' && $row['section_id'] != 0) {
                    $this->db->where('section_id' , $row['section_id']);
                }
                $this->db->where('session' , $session);

                $this->db->update('attendance' , array('status' => $attendance_status));

                if ($attendance_status == 2) {

                    if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                        $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                        $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                        $this->sms_model->send_sms($message,$receiver_phone);
                    }
                }

            }

			$this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
			redirect(base_url() . 'index.php?admin/manage_attendance/'.$date.'/'.$month.'/'.$year.'/'.$class_id.'/'.$section_id.'/'.$session , 'refresh');
		}
        $page_data['date']       =	$date;
        $page_data['month']      =	$month;
        $page_data['year']       =	$year;
        $page_data['class_id']   =  $class_id;
        $page_data['section_id'] =  $section_id;
        $page_data['session']    =  $session;

        $page_data['page_name']  =	'manage_attendance';
        $page_data['page_title'] =	get_phrase('manage_daily_attendance');
		$this->load->view('backend/index', $page_data);
	}

	function attendance_selector2()
	{
        //$session = $this->input->post('session');
        //$encoded_session = urlencode( base64_encode( $session ) );
		redirect(base_url() . 'index.php?admin/manage_attendance/'.$this->input->post('date').'/'.
					$this->input->post('month').'/'.
						$this->input->post('year').'/'.
							$this->input->post('class_id').'/'.
                                $this->input->post('section_id').'/'.
                                    $this->input->post('session') , 'refresh');
	}

     ///////ATTENDANCE REPORT /////
     function attendance_report() {
         $page_data['month']        = date('m');
         $page_data['page_name']    = 'attendance_report';
         $page_data['page_title']   = get_phrase('attendance_report');
         $this->load->view('backend/index',$page_data);
     }

     function attendance_report_view($class_id = '', $section_id = '', $month = '', $sessional_year = '')
     {
         if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name                     = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
        $section_name                   = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
        $page_data['class_id']          = $class_id;
        $page_data['section_id']        = $section_id;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $page_data['page_name']         = 'attendance_report_view';
        $page_data['page_title']        = get_phrase('attendance_report_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
     }

     function attendance_report_print_view($class_id ='' , $section_id = '' , $month = '', $sessional_year = '') {
          if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['class_id']          = $class_id;
        $page_data['section_id']        = $section_id;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $this->load->view('backend/admin/attendance_report_print_view' , $page_data);
    }

    function attendance_report_selector()
    {   if($this->input->post('class_id') == '' || $this->input->post('sessional_year') == '') {
            $this->session->set_flashdata('error_message' , get_phrase('please_make_sure_class_and_sessional_year_are_selected'));
            redirect(base_url() . 'index.php?admin/attendance_report', 'refresh');
        }
        $data['class_id']       = $this->input->post('class_id');
        $data['section_id']     = $this->input->post('section_id');
        $data['month']          = $this->input->post('month');
        $data['sessional_year'] = $this->input->post('sessional_year');
        redirect(base_url() . 'index.php?admin/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'] . '/' . $data['sessional_year'], 'refresh');
    }

    /** 
    STAFF ATTENDNACE
    **/
    function staffAttendance()
    {
        if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $page_data['page_name']  =  'staff_attendance';
        $page_data['page_title'] =  get_phrase('manage_attendance_of_staffs');
        $this->load->view('backend/index', $page_data);
    }

    function get_staff_holder($type_id) {
        $page_data['type_id'] = $type_id;
        $this->load->view('backend/admin/manage_staff_attendance_holder' , $page_data);
    }

    function staff_attendance_selector()
    {
        $data['staff_type']   = $this->input->post('staff_type');
        //$data['staff_id']   = $this->input->post('staff_id');
        $data['year']       = $this->input->post('year');
        $data['timestamp']  = strtotime($this->input->post('timestamp'));
        
        $query = $this->db->get_where('staff_attendance' ,array(
            'staff_type'=>$data['staff_type'],
                //'staff_id'=>$data['staff_id'],
                    'year'=>$data['year'],
                        'timestamp'=>$data['timestamp']
        ));
        if($query->num_rows() < 1) {

            if($data['staff_type'] == 'teacher') {
                $teachers = $this->db->get('teacher')->result_array();

                foreach($teachers as $row) {
                    $attn_data['staff_type'] = $data['staff_type'];
                    $attn_data['year']       = $data['year'];
                    $attn_data['timestamp']  = $data['timestamp'];
                    $attn_data['staff_id']   = $row['teacher_id'];
                    $this->db->insert('staff_attendance' , $attn_data);
                }

            }elseif($data['staff_type'] == 'accountant'){

                $accountant = $this->db->get('accountant')->result_array();

                foreach($accountant as $row) {
                    $attn_data['staff_type'] = $data['staff_type'];
                    $attn_data['year']       = $data['year'];
                    $attn_data['timestamp']  = $data['timestamp'];
                    $attn_data['staff_id']   = $row['accountant_id'];
                    $this->db->insert('staff_attendance' , $attn_data);
                }

            }elseif($data['staff_type'] == 'librarian'){

                $librarian = $this->db->get('librarian')->result_array();

                foreach($librarian as $row) {
                    $attn_data['staff_type'] = $data['staff_type'];
                    $attn_data['year']       = $data['year'];
                    $attn_data['timestamp']  = $data['timestamp'];
                    $attn_data['staff_id']   = $row['librarian_id'];
                    $this->db->insert('staff_attendance' , $attn_data);
                }

            }elseif($data['staff_type'] == 'employee'){

                $employee = $this->db->get('employee')->result_array();

                foreach($employee as $row) {
                    $attn_data['staff_type'] = $data['staff_type'];
                    $attn_data['year']       = $data['year'];
                    $attn_data['timestamp']  = $data['timestamp'];
                    $attn_data['staff_id']   = $row['emp_id'];
                    $this->db->insert('staff_attendance' , $attn_data);
                }
            }            

        }
        redirect(base_url().'index.php?admin/manage_staff_attendance_view/'.$data['staff_type'].'/'.$data['timestamp'],'refresh');
    }

    function manage_staff_attendance_view($staff_type = '' , $timestamp = '')
    {
        if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'manage_staff_attendance_view';

        $page_data['staff_type'] = $staff_type;
        $page_data['page_title'] = get_phrase('manage_attendance_of_staffs') . ' ' . $staff_type ;
         $this->load->view('backend/index', $page_data);
    }

    function staff_attendance_update($staff_type = '' , $timestamp = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        
        $attendance_of_staffs = $this->db->get_where('staff_attendance' , array(
            'staff_type'=>$staff_type, 'year'=>$running_year, 'timestamp'=>$timestamp
        ))->result_array();

        foreach($attendance_of_staffs as $row) {

            $attendance_status = $this->input->post('status_'.$row['staff_att_id']);

            $this->db->where('staff_att_id' , $row['staff_att_id']);
            $this->db->update('staff_attendance' , array('status' => $attendance_status));

        }

        $this->session->set_flashdata('flash_message' , get_phrase('staff_attendance_updated'));
        redirect(base_url().'index.php?admin/manage_staff_attendance_view/'.$staff_type.'/'.$timestamp , 'refresh');
    }

    /** STAFF ATTENDANCE REPORT **/
     function staffAttendanceReport() {
         $page_data['month']        = date('m');
         $page_data['page_name']    = 'staff_attendance_report';
         $page_data['page_title']   = get_phrase('staff_attendance_report');
         $this->load->view('backend/index',$page_data);
     }

    function staff_attendance_report_selector()
    {   
        if($this->input->post('staff_type') == '' || $this->input->post('sessional_year') == '') {

            $this->session->set_flashdata('error_message' , get_phrase('please_make_sure_staff_designation_and_sessional_year_are_selected'));
            redirect(base_url() . 'index.php?admin/staff_attendance_report', 'refresh');

        }

        $data['staff_type']     = $this->input->post('staff_type');
        $data['month']          = $this->input->post('month');
        $data['sessional_year'] = $this->input->post('sessional_year');

        redirect(base_url() . 'index.php?admin/staff_attendance_report_view/' . $data['staff_type'] . '/' . $data['month'] . '/' . $data['sessional_year'], 'refresh');
    }

    function staff_attendance_report_view($staff_type = '', $month = '', $sessional_year = '')
     {
         if($this->session->userdata('admin_login')!=1)
            redirect(base_url() , 'refresh');

        $page_data['staff_type']        = $staff_type;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $page_data['page_name']         = 'staff_attendance_report_view';
        $page_data['page_title']        = get_phrase('attendance_report_of') . ' : ' . $staff_type;
        $this->load->view('backend/index', $page_data);
     }

     function staff_attendance_report_print_view($staff_type ='' , $month = '', $sessional_year = '') {
          if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['staff_type']        = $staff_type;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $this->load->view('backend/admin/staff_attendance_report_print_view' , $page_data);
    }

    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {

            //array to store information in db::table->invoice
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']                = $data['amount'] - $data['amount_paid'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }

            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            //array to store information in db::table->payment
            $data2['invoice_id']        =  $invoice_id;
            $data2['student_id']        =  $this->input->post('student_id');
            $data2['title']             =  $this->input->post('title');
            $data2['payment_type']      =  'income';
            $data2['method']            =  $this->input->post('method');
            $data2['amount']            =  $this->input->post('amount_paid');
            $data2['timestamp']         =  strtotime($this->input->post('date'));
            $data2['year']              =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            if ($this->input->post('description') != null) {
                $data2['description']    = $this->input->post('description');
            }

            $this->db->insert('payment' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
        }

        if ($param1 == 'create_mass_invoice') {
            foreach ($this->input->post('student_id') as $id) {

                $data['student_id']         = $id;
                $data['title']              = $this->input->post('title');
                $data['description']        = $this->input->post('description');
                $data['amount']             = $this->input->post('amount');
                $data['amount_paid']        = $this->input->post('amount_paid');
                $data['due']                = $data['amount'] - $data['amount_paid'];
                $data['status']             = $this->input->post('status');
                $data['creation_timestamp'] = strtotime($this->input->post('date'));
                $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('invoice', $data);
                $invoice_id = $this->db->insert_id();

                $data2['invoice_id']        =   $invoice_id;
                $data2['student_id']        =   $id;
                $data2['title']             =   $this->input->post('title');
                $data2['description']       =   $this->input->post('description');
                $data2['payment_type']      =  'income';
                $data2['method']            =   $this->input->post('method');
                $data2['amount']            =   $this->input->post('amount_paid');
                $data2['timestamp']         =   strtotime($this->input->post('date'));
                $data2['year']               =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('payment' , $data2);
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/student_payment', 'refresh');
        }

        if ($param1 == 'do_update') {

            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/income', 'refresh');

        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }

        if ($param1 == 'take_payment') {

            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
            $data['year']         =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);

            $status['status']   =   $this->input->post('status');
            $this->db->where('invoice_id' , $param2);
            $this->db->update('invoice' , array('status' => $status['status']));

            $data2['amount_paid']   =   $this->input->post('amount');
            $data2['status']        =   $this->input->post('status');

            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?admin/income/', 'refresh');

        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/income', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**********ACCOUNTING********************/
    function income($param1 = 'invoices' , $param2 = '')
    {
       if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param2 == 'filter_history')
            $page_data['student_id'] = $this->input->post('student_id');
        else
            $page_data['student_id'] = 'all';

        $page_data['page_name']  = 'income';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $page_data['active_tab']  = $param1;
        $this->load->view('backend/index', $page_data);
    }

    function student_payment($param1 = '' , $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        $page_data['page_name']  = 'student_payment';
        $page_data['page_title'] = get_phrase('create_student_payment');
        $this->load->view('backend/index', $page_data);
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            else{
                $data['description']     =   null;
            }
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense', 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data);
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/expense_category');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = get_phrase('expense_category');
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['class_id']    = $this->input->post('class_id');
            if ($this->input->post('description') != null) {
               $data['description'] = $this->input->post('description');
            }
            if ($this->input->post('price') != null) {
               $data['price'] = $this->input->post('price');
            }
            if ($this->input->post('author') != null) {
               $data['author'] = $this->input->post('author');
            }


            $this->db->insert('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['class_id']    = $this->input->post('class_id');
            if ($this->input->post('description') != null) {
               $data['description'] = $this->input->post('description');
            }
            else{
               $data['description'] = null;
            }
            if ($this->input->post('price') != null) {
               $data['price'] = $this->input->post('price');
            }
            else{
                $data['price'] = null;
            }
            if ($this->input->post('author') != null) {
               $data['author'] = $this->input->post('author');
            }
            else{
               $data['author'] = null;
            }
            $this->db->where('book_id', $param2);
            $this->db->update('book', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('book', array(
                'book_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/book', 'refresh');
        }
        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            if ($this->input->post('description') != null) {
               $data['description']    = $this->input->post('description');
            }
            if ($this->input->post('route_fare') != null) {
               $data['route_fare']     = $this->input->post('route_fare');
            }

            $this->db->insert('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/transport', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            if ($this->input->post('description') != null) {
               $data['description']    = $this->input->post('description');
            }
            else{
                $data['description'] = null;
            }
            if ($this->input->post('route_fare') != null) {
               $data['route_fare']   = $this->input->post('route_fare');
            }
            else{
                $data['route_fare']  = null;
            }

            $this->db->where('transport_id', $param2);
            $this->db->update('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/transport', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('transport', array(
                'transport_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('transport_id', $param2);
            $this->db->delete('transport');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/transport', 'refresh');
        }
        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE DORMITORY / HOSTELS / ROOMS ********************/
    function dormitory($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']           = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }

            $this->db->insert('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']           = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }
            else{
                $data['description'] = null;
            }
            $this->db->where('dormitory_id', $param2);
            $this->db->update('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('dormitory', array(
                'dormitory_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('dormitory_id', $param2);
            $this->db->delete('dormitory');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/dormitory', 'refresh');
        }

        $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['page_name']   = 'dormitory';
        $page_data['page_title']  = get_phrase('manage_dormitory');
        $this->load->view('backend/index', $page_data);

    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        if ($param1 == 'mark_as_archive') {
            $this->db->where('notice_id' , $param2);
            $this->db->update('noticeboard' , array('status' => 0));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }

        if ($param1 == 'remove_from_archived') {
            $this->db->where('notice_id' , $param2);
            $this->db->update('noticeboard' , array('status' => 1));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $this->load->view('backend/index', $page_data);
    }

    function reload_noticeboard() {
        $this->load->view('backend/admin/noticeboard');
    }

    /* private messaging */
    function message($param1 = 'message_home', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $max_size = 2097152;
        if ($param1 == 'send_new') {
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }

            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                redirect(base_url() . 'index.php?admin/message/message_new/', 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {

            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('sms_sender_title');
            $this->db->where('type' , 'sms_sender_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paystack_public_key');
            $this->db->where('type' , 'paystack_public_key');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paystack_secret_key');
            $this->db->where('type' , 'paystack_secret_key');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type' , 'text_align');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('running_year');
            $this->db->where('type' , 'running_year');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }

        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }

        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }

        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    function get_session_changer()
    {
        $this->load->view('backend/admin/change_session');
    }

    function change_session()
    {
        $data['description'] = $this->input->post('running_year');
        $this->db->where('type' , 'running_year');
        $this->db->update('settings' , $data);
        $this->session->set_flashdata('flash_message' , get_phrase('session_changed'));
        redirect(base_url() . 'index.php?admin/dashboard/', 'refresh');
    }

	/***** UPDATE PRODUCT *****/

	function update( $task = '', $purchase_code = '' ) {

        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        // Create update directory.
        $dir    = 'update';
        if ( !is_dir($dir) )
            mkdir($dir, 0777, true);

        $zipped_file_name   = $_FILES["file_name"]["name"];
        $path               = 'update/' . $zipped_file_name;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);

        // Unzip uploaded update file and remove zip file.
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }

        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str                = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json               = json_decode($str, true);



		// Run php modifications
		require './update/' . $unzipped_file_name . '/update_script.php';

        // Create new directories.
        if(!empty($json['directory'])) {
            foreach($json['directory'] as $directory) {
                if ( !is_dir( $directory['name']) )
                    mkdir( $directory['name'], 0777, true );
            }
        }

        // Create/Replace new files.
        if(!empty($json['files'])) {
            foreach($json['files'] as $file)
                copy($file['root_directory'], $file['update_directory']);
        }

        $this->session->set_flashdata('flash_message' , get_phrase('product_updated_successfully'));
        redirect(base_url() . 'index.php?admin/system_settings');
    }

    /*****SMS SETTINGS*********/
    function sms_settings($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'clickatell') {

            $data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type' , 'clickatell_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type' , 'clickatell_api_id');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'twilio') {

            $data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type' , 'twilio_account_sid');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type' , 'twilio_auth_token');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type' , 'twilio_sender_phone_number');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'msg91') {

            $data['description'] = $this->input->post('authentication_key');
            $this->db->where('type' , 'msg91_authentication_key');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('sender_ID');
            $this->db->where('type' , 'msg91_sender_ID');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'ebulksms') {

            $data['description'] = $this->input->post('username');
            $this->db->where('type' , 'ebulk_sms_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('api_key');
            $this->db->where('type' , 'ebulk_sms_apikey');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'bulksmsnigeria') {

            $data['description'] = $this->input->post('username');
            $this->db->where('type' , 'bulksmsnigeria_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('password');
            $this->db->where('type' , 'bulksmsnigeria_pass');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        if ($param1 == 'active_service') {

            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type' , 'active_sms_service');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/sms_settings/', 'refresh');
        }

        $page_data['page_name']  = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
			redirect(base_url() . 'index.php?login', 'refresh');

		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] 	= $param2;
		}
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++)
			{
				//$data[$language]	=	$this->input->post('phrase').$i;
				$this->db->where('phrase_id' , $i);
				$this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
			}
			redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/'.$language, 'refresh');
		}
		if ($param1 == 'do_update') {
			$language        = $this->input->post('language');
			$data[$language] = $this->input->post('phrase');
			$this->db->where('phrase_id', $param2);
			$this->db->update('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_phrase') {
			$data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
		}
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT'
				)
			);
			$this->dbforge->add_column('language', $fields);

			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
		}
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

			redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
		}
		$page_data['page_name']        = 'manage_language';
		$page_data['page_title']       = get_phrase('manage_language');
		//$page_data['language_phrases'] = $this->db->get('language')->result_array();
		$this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $operation
     * @param string $type
     * BackUp/Restore/Delete Page Data
     */
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }

        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }

        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }

        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {

            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['username'] = $this->input->post('username');

            $admin_id = $param2;

            $validation = email_validation_for_edit($data['email'], $admin_id, 'admin');

            if($validation == 1){

                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $this->session->userdata('admin_id') . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }

        if ($param1 == 'change_password') {

            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->row()->password;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }

            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }

        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');

        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $this->session->userdata('admin_id')
        ))->result_array();

        $this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $param1
     * @param string $param2
     * View Question Papers
     */
    function question_paper($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $data['page_name']  = 'question_paper';
        $data['page_title'] = get_phrase('question_paper');
        $this->load->view('backend/index', $data);
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Manage Librarians
     */
    function librarian($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['email']      = $this->input->post('email');
            $data['username']      = $this->input->post('username');
            $data['password']   = sha1($this->input->post('password'));

            $validation = librarian_username_validation($data['username']);
            if ($validation == 1) {
                $this->db->insert('librarian', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                //$this->email_model->account_opening_email('librarian', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }
            redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']   = $this->input->post('name');
            $data['email']  = $this->input->post('email');
            $data['username']  = $this->input->post('username');

            $validation = librarian_username_validation_for_edit($data['username'], $param2, 'librarian');
            if ($validation == 1) {
                $this->db->where('librarian_id' , $param2);
                $this->db->update('librarian' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('librarian_id' , $param2);
            $this->db->delete('librarian');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/librarian/', 'refresh');
        }

        $page_data['page_title']    = get_phrase('all_librarians');
        $page_data['page_name']     = 'librarian';
        $this->load->view('backend/index', $page_data);
    }

    // MANAGE ACCOUNTANTS
    function accountant($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['email']      = $this->input->post('email');
            $data['username']      = $this->input->post('username');
            $data['password']   = sha1($this->input->post('password'));

            $validation = accountant_username_validation($data['username']);
            if ($validation == 1) {
                $this->db->insert('accountant', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                //$this->email_model->account_opening_email('accountant', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_username_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/accountant', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']   = $this->input->post('name');
            $data['email']  = $this->input->post('email');
            $data['username']      = $this->input->post('username');

            $validation = accountant_username_validation_for_edit($data['username'], $param2, 'accountant');
            if($validation == 1){
                $this->db->where('accountant_id' , $param2);
                $this->db->update('accountant' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(base_url() . 'index.php?admin/accountant', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('accountant_id' , $param2);
            $this->db->delete('accountant');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/accountant', 'refresh');
        }

        $page_data['page_title']    = get_phrase('all_accountants');
        $page_data['page_name']     = 'accountant';
        $this->load->view('backend/index', $page_data);
    }

    /**
    MANAGE PAYROLL fuctions here
    **/

    //Pay head master
    function payHeadMaster($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['pay_head_name']  = $this->input->post('pay_head_name');
            $data['description']    = $this->input->post('description');
            $data['action']         = $this->input->post('action');        

            $this->db->insert('pay_head', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/payHeadMaster', 'refresh');              
        }

        if ($param1 == 'edit') {
            $data['pay_head_name']  = $this->input->post('pay_head_name');
            $data['description']    = $this->input->post('description');
            $data['action']         = $this->input->post('action');

            $this->db->where('pay_head_id' , $param2);
            $this->db->update('pay_head' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/payHeadMaster', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('pay_head_id' , $param2);
            $this->db->delete('pay_head');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/payHeadMaster', 'refresh');
        }

        $page_data['page_title']    = get_phrase('pay_head_type');
        $page_data['page_name']     = 'pay_head';
        $this->load->view('backend/index', $page_data);

    }

    //Payable Types
    function payableTypes($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['payable_name']  = $this->input->post('payable_name');    

            $this->db->insert('payable_types', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/payableTypes', 'refresh');              
        }

        if ($param1 == 'edit') {
            $data['payable_name']  = $this->input->post('payable_name');

            $this->db->where('payable_id' , $param2);
            $this->db->update('payable_types' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/payableTypes', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payable_id' , $param2);
            $this->db->delete('payable_types');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/payableTypes', 'refresh');
        }

        $page_data['page_title']    = get_phrase('payable_types');
        $page_data['page_name']     = 'payable_type';
        $this->load->view('backend/index', $page_data);

    }

    //Salary Settings
    function salarySettings($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'add') {
            $data['staff_type']  = $this->input->post('staff_type'); 
            $data['staff_id']    = $this->input->post('staff_id');  
            $data['pay_head_id'] = $this->input->post('pay_head_id');
            $data['unit'] = $this->input->post('unit');
            $data['type'] = $this->input->post('type');


            $this->db->insert('salary_settings', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/salarySettings', 'refresh');              
        }

        if ($param1 == 'edit') {
            $data['pay_head_id'] = $this->input->post('pay_head_id');
            $data['unit'] = $this->input->post('unit');
            $data['type'] = $this->input->post('type');

            $this->db->where('id' , $param2);
            $this->db->update('salary_settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/salarySettings', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('salary_settings');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/salarySettings', 'refresh');
        }

        $page_data['page_title']    = get_phrase('salary_settings');
        $page_data['page_name']     = 'salary_settings';
        $this->load->view('backend/index', $page_data);
    }

    //Staff Salary
    function staffSalary($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'add') {
            $data['staff_type']  = $this->input->post('staff_type'); 
            $data['staff_id']    = $this->input->post('staff_id');  
            $data['year']        = $this->input->post('year');
            $data['month']       = $this->input->post('month');
            $data['start_date']  = $this->input->post('start_date');
            $data['end_date']    = $this->input->post('end_date');


            $this->db->insert('staff_salary', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/staffSalary', 'refresh');              
        }

        if ($param1 == 'edit') {
            $data['year']        = $this->input->post('year');
            $data['month']       = $this->input->post('month');
            $data['start_date']  = $this->input->post('start_date');
            $data['end_date']    = $this->input->post('end_date');

            $this->db->where('id' , $param2);
            $this->db->update('staff_salary' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/staffSalary', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('staff_salary');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/staffSalary', 'refresh');
        }

        $page_data['page_title']    = get_phrase('set_staff_salary');
        $page_data['page_name']     = 'staff_salary';
        $this->load->view('backend/index', $page_data);

    }

    /**
    LEAVE MANAGEMENT
    **/

    //leave category
    function leaveCategory($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'add') {

            $data['category_name']  = $this->input->post('category_name'); 
            $this->db->insert('leave_category', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/leaveCategory', 'refresh');              
        }

        if ($param1 == 'edit') {

            $data['category_name']  = $this->input->post('category_name'); 

            $this->db->where('id' , $param2);
            $this->db->update('leave_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/leaveCategory', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('leave_category');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/leaveCategory', 'refresh');
        }

        $page_data['page_title']    = get_phrase('leave_category');
        $page_data['page_name']     = 'leave_category';
        $this->load->view('backend/index', $page_data);

    }

    //leave application
    function leaveApplication($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'add') {

            $data['staff_type'] = $this->input->post('staff_type'); 
            $data['staff_id']   = $this->input->post('staff_id'); 
            $data['leave_category_id']  = $this->input->post('leave_category_id'); 
            $data['from'] = $this->input->post('from'); 
            $data['to']  = $this->input->post('to'); 
            $data['reason']  = $this->input->post('reason'); 

            $this->db->insert('leave_application', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully')); 

            redirect(base_url() . 'index.php?admin/leaveApplication', 'refresh');              
        }

        if ($param1 == 'do_update') {

            $data['leave_category_id']  = $this->input->post('leave_category_id'); 
            $data['from'] = $this->input->post('from'); 
            $data['to']  = $this->input->post('to'); 
            $data['reason']  = $this->input->post('reason'); 

            $this->db->where('id' , $param2);
            $this->db->update('leave_application' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));          

            redirect(base_url() . 'index.php?admin/leaveApplication', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('leave_application');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/leaveApplication', 'refresh');
        }

        if ($param1 == 'change_status') {

            $data['status'] = $param3;
            $this->db->where('id' , $param2);
            $this->db->update('leave_application' , $data);            
            
            $this->session->set_flashdata('flash_message' , get_phrase('leave_status_updated'));
            redirect(base_url() . 'index.php?admin/leaveApplication', 'refresh');
        }

        $page_data['page_title']    = get_phrase('leave_application');
        $page_data['page_name']     = 'leave_application';
        $this->load->view('backend/index', $page_data);

    }

    /**Generate unique numeric code for all students user types **/
    function generateStudentCode()
    {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 7; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    function generateTeacherCode()
    {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 7; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    function generateEmployeeCode()
    {
        $alphabet = "0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 7; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }

    /****GENERATE & MANAGE SCRATCH CARDS*****/
    function scratch_cards($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if ($param1 == 'create') {
            $data['year']       = $this->input->post('year');
            $data['exam_id']    = $this->input->post('exam_id');
            $data['type']       = $this->input->post('type');
            $data['duration']   = $this->input->post('duration');
            $data['total']      = $this->input->post('total');   //number of cards to print
            $data['price']      = $this->input->post('price');

            $x = 0;
            while ($x++ <= $data['total'])
            {
                $data['pin'] = $this->getRandomCharacter();

                //we can check if pin already exists in table before insert
                $this->db->where('pin', $data['pin']);
                $query = $this->db->get('cards');

                if($query->num_rows() > 0){
                    exit();
                }

                $this->db->insert('cards', $data);
            }

            $this->session->set_flashdata('flash_message' , get_phrase('result_pins_generated_successfully'));
            redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
        }

        //delete scratch cards
        if ($param1 == 'delete') {
            $this->db->where('card_id', $param2);
            $this->db->delete('cards');
            $this->session->set_flashdata('flash_message' , get_phrase('pin_deleted'));
            redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
        }

        if ($param1 == 'delete_all') {
            $this->db->empty_table('cards');
            $this->session->set_flashdata('flash_message' , get_phrase('result_pins_removed'));
            redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
        }

        $page_data['cards']      = $this->db->get('cards')->result_array();
        $page_data['page_name']  = 'cards';
        $page_data['page_title'] = get_phrase('scratched_cards');
        $this->load->view('backend/index', $page_data);
    }

    function assign_scratch_pins($param1 = '', $param2 = '') {

        if ($this->session->userdata('admin_login') != 1)
            redirect('login', 'refresh');

        if($param1 == 'assign') {

            /**
             * check if student already has pin assigned to him/her
             */
            $data['student_id'] = $this->input->post('student_id');
            $this->db->where('student_id', $data['student_id']);
            $this->db->from('cards');
            $stud_check = $this->db->count_all_results();

            if($stud_check > 0) {
                $this->session->set_flashdata('error_message' , get_phrase('student_already_assigned_pin'));
                redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
            }

            /**
             * check if that pin has been assigned already
             */
            $data['assigned'] = '1';
            $check = $this->db->get_where('cards' , array('card_id' => $param2))->row()->assigned;

            if($check == '1') {
                $this->session->set_flashdata('error_message' , get_phrase('pin_already_assigned'));
                redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
            }

            $this->db->where('card_id' , $param2);
            $this->db->update('cards' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('pin_assigned_successfully'));
            redirect(base_url() . 'index.php?admin/scratch_cards/', 'refresh');
        }
    }

    /**
     * @param int $length
     * @param bool $use_upper_case
     * @param bool $include_numbers
     * @param bool $include_special_chars
     * @return string
     * algo to generate random strings as pin
     * fixed length of 10
     */
    private function getRandomCharacter($length = 10, $use_upper_case=true, $include_numbers=true, $include_special_chars=false)
    {
        $selection = 'AEUOYIBCDFGHJKLMNPGRSTVWXZ';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $characters = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $characters .=  $current_letter;
        }

        return $characters;
    }

    /****SEND BULK SMS*****/
    function bulk_sms($param1 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url('index.php?login'), 'refresh');

        if($param1 == 'send_bulk_sms') {

            $recipients = $_POST['telephone'];
            $message    = $_POST['message'];

            if (get_magic_quotes_gpc()) {
                $message = stripslashes($_POST['message']);
            }

            $message = substr($_POST['message'], 0, 160);

            // send sms
            $this->sms_model->send_sms( $message , $recipients );

            $this->session->set_flashdata('flash_message' , get_phrase('sms_delivered'));
            redirect(base_url() . 'index.php?admin/bulk_sms/', 'refresh');
        }

        $page_data['page_name']  = 'bulk_sms';
        $page_data['page_title'] = get_phrase('bulk_sms');
        $this->load->view('backend/index', $page_data);
    }

    function frontend_pages($param1 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if($param1 == 'general') {
            $page_data['page_name']  = 'frontend_pages';
            $page_data['page_title'] = get_phrase('frontend_pages');
            $page_data['settings']   = $this->db->get('settings_frontend')->result_array();

            $this->load->view('backend/index', $page_data);
        }

        if ($param1 == 'homepage_slider') {
            $page_data['page_name']  = 'homepage_slider';
            $page_data['page_title'] = get_phrase('homepage_slider');
            $page_data['settings']   = $this->db->get('settings_frontend')->result_array();

            $this->load->view('backend/index', $page_data);
        }

        if($param1 == 'privacy_policy') {
            $page_data['page_name']  = 'privacy_policy';
            $page_data['page_title'] = get_phrase('privacy_policy');
            $page_data['settings']   = $this->db->get('settings_frontend')->result_array();
        }

        if($param1 == 'terms_conditions') {
            $page_data['page_name']  = 'terms_conditions';
            $page_data['page_title'] = get_phrase('terms_conditions');
            $page_data['settings']   = $this->db->get('settings_frontend')->result_array();

            $this->load->view('backend/index', $page_data);
        }

        if($param1 == 'about_us') {
            $page_data['page_name']  = 'about_us';
            $page_data['page_title'] = get_phrase('about_us');
            $page_data['settings']   = $this->db->get('settings_frontend')->result_array();

            $this->load->view('backend/index', $page_data);
        }

        if($param1 == 'events') {
            $page_data['page_name']  = 'events';
            $page_data['page_title'] = get_phrase('events');
            $page_data['events']   = $this->db->get('events')->result_array();

            $this->load->view('backend/index', $page_data);
        }
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * FRONTEND SETTINGS [PAGES]
     */
    function frontend_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_general_settings') {

            $data['description'] = $this->input->post('school_title');
            $this->db->where('type' , 'school_title');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('school_email');
            $this->db->where('type' , 'school_email');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('copyright_text');
            $this->db->where('type' , 'copyright_text');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('geo_code');
            $this->db->where('type' , 'geo_code');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('facebook_profile');
            $this->db->where('type' , 'facebook_profile');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('twitter_profile');
            $this->db->where('type' , 'twitter_profile');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('linkedin_profile');
            $this->db->where('type' , 'linkedin_profile');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('google_profile');
            $this->db->where('type' , 'google_profile');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('homepage_note_title');
            $this->db->where('type' , 'homepage_note_title');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('homepage_note_description');
            $this->db->where('type' , 'homepage_note_description');
            $this->db->update('settings_frontend' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/general', 'refresh');
        }

        if ($param1 == 'update_slider_images') {

            $data['description'] = $this->input->post('title_0');
            $this->db->where('type' , 'slider_title_0');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('title_1');
            $this->db->where('type' , 'slider_title_1');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('title_2');
            $this->db->where('type' , 'slider_title_2');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('description_0');
            $this->db->where('type' , 'slider_description_0');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('description_1');
            $this->db->where('type' , 'slider_description_1');
            $this->db->update('settings_frontend' , $data);

            $data['description'] = $this->input->post('description_2');
            $this->db->where('type' , 'slider_description_2');
            $this->db->update('settings_frontend' , $data);

            move_uploaded_file($_FILES['slider_image_0']['tmp_name'], 'uploads/frontend/slider/0.jpg');
            move_uploaded_file($_FILES['slider_image_1']['tmp_name'], 'uploads/frontend/slider/1.jpg');
            move_uploaded_file($_FILES['slider_image_2']['tmp_name'], 'uploads/frontend/slider/2.jpg');

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/general', 'refresh');
        }

        if ($param1 == 'update_privacy_policy') {

            $data['description'] = $this->input->post('privacy_policy');
            $this->db->where('type' , 'privacy_policy');
            $this->db->update('settings_frontend' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/privacy_policy', 'refresh');
        }

        if ($param1 == 'update_terms_conditions') {

            $data['description'] = $this->input->post('terms_conditions');
            $this->db->where('type' , 'terms_conditions');
            $this->db->update('settings_frontend' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/terms_conditions', 'refresh');
        }

        if ($param1 == 'update_about_us') {

            $data['description'] = $this->input->post('about_us');
            $this->db->where('type' , 'about_us');
            $this->db->update('settings_frontend' , $data);

            move_uploaded_file($_FILES['about_us_image']['tmp_name'], 'uploads/frontend/about/default.jpg');

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/about_us', 'refresh');
        }
    }

    public function frontend_events($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'add_event') {
            $data['title']   = $this->input->post('title');
            $data['date']    = strtotime($this->input->post('timestamp'));
            $data['status']  = $this->input->post('status');
            $this->db->insert('events', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('events_added_successfully'));
            redirect(base_url() . 'index.php?admin/frontend_pages/events', 'refresh');
        }

        if($param1 == 'do_update_events') {
            $data['title']  = $this->input->post('title');
            $data['date']   = strtotime($this->input->post('timestamp'));
            $data['status'] = $this->input->post('status');
            $this->db->where('event_id', $param2);
            $this->db->update('events', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/frontend_pages/events', 'refresh');

        }

        if($param1 == 'delete') {
            $this->db->where('event_id', $param2);
            $this->db->delete('events');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/frontend_pages/events', 'refresh');
        }
    }

    public function frontend_themes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'change_theme_skin') {
            $data['description'] = $param2;

            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings_frontend' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('theme_colour_selected'));
            redirect(base_url() . 'index.php?admin/frontend_themes/', 'refresh');
        }

        $page_data['page_name']  = 'frontend_themes';
        $page_data['page_title'] = get_phrase('frontend_themes');
        $page_data['settings']   = $this->db->get('settings_frontend')->result_array();
        $this->load->view('backend/index', $page_data);

    }

    public function result_checker_settings($param1='')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url('index.php?login'), 'refresh');

        if($param1 == 'update_settings') {

            $data['description'] = $_POST['value'];
            $this->db->where('type' , 'scratch_card_active');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/result_checker_settings/', 'refresh');
        }

        $page_data['page_name']  = 'result_checker_settings';
        $page_data['page_title'] = get_phrase('result_checker_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**GENERATE ID CARDS **/

    function teacher_id_card($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher_id_card';
        $page_data['page_title'] = get_phrase('manage_teacher_id_card');
        $this->load->view('backend/index', $page_data);
    }

    function student_id_card($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['students']   = $this->db->get('student')->result_array();
        $page_data['page_name']  = 'student_id_card';
        $page_data['page_title'] = get_phrase('manage_student_id_card');
        $this->load->view('backend/index', $page_data);
    }

    function accountant_id_card($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher_id_card';
        $page_data['page_title'] = get_phrase('manage_teacher_id_card');
        $this->load->view('backend/index', $page_data);
    }

    /** USERNAME CHECK **/

    function parentUsernameCheck()
    {
        if(!empty($_POST["username"])) {
            $result = $this->db->query("SELECT username FROM parent WHERE username='" . $_POST["username"] . "'");

            if($result->num_rows() > 0) {
                echo "<span class='status-not-available' style='color: #df3826;'> Username Not Available.</span>";
            }else{
                echo "<span class='status-available' style='color: green;'> Username Available.</span>";
            }
        }
    }

    function teacherUsernameCheck()
    {
        if(!empty($_POST["username"])) {
            $result = $this->db->query("SELECT username FROM teacher WHERE username='" . $_POST["username"] . "'");

            if($result->num_rows() > 0) {
                echo "<span class='status-not-available' style='color: #df3826;'> Username Not Available.</span>";
            }else{
                echo "<span class='status-available' style='color: green;'> Username Available.</span>";
            }
        }
    }

    function librarianUsernameCheck()
    {
        if(!empty($_POST["username"])) {
            $result = $this->db->query("SELECT username FROM librarian WHERE username='" . $_POST["username"] . "'");

            if($result->num_rows() > 0) {
                echo "<span class='status-not-available' style='color: #df3826;'> Username Not Available.</span>";
            }else{
                echo "<span class='status-available' style='color: green;'> Username Available.</span>";
            }
        }
    }

    function accountantUsernameCheck()
    {
        if(!empty($_POST["username"])) {
            $result = $this->db->query("SELECT username FROM accountant WHERE username='" . $_POST["username"] . "'");

            if($result->num_rows() > 0) {
                echo "<span class='status-not-available' style='color: #df3826;'> Username Not Available.</span>";
            }else{
                echo "<span class='status-available' style='color: green;'> Username Available.</span>";
            }
        }
    }



}
