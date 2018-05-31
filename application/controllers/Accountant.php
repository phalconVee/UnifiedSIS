<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Accountant extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default functin, redirects to login page if no accountant logged in yet***/
    public function index()
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('accountant_login') == 1)
            redirect(base_url() . 'index.php?accountant/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('accountant_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            if ($this->input->post('description') != null) {
                $data['description']        = $this->input->post('description');
            }
            
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']                = $data['amount'] - $data['amount_paid'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            
            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();

            $data2['invoice_id']        =   $invoice_id;
            $data2['student_id']        =   $this->input->post('student_id');
            $data2['title']             =   $this->input->post('title');
            if ($this->input->post('description') != null) {
                $data['description']        = $this->input->post('description');
            }
            $data2['payment_type']      =  'income';
            $data2['method']            =   $this->input->post('method');
            $data2['amount']            =   $this->input->post('amount_paid');
            $data2['timestamp']         =   strtotime($this->input->post('date'));
            $data2['year']              =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $this->db->insert('payment' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?accountant/student_payment', 'refresh');
        }

        if ($param1 == 'create_mass_invoice') {
            foreach ($this->input->post('student_id') as $id) {

                $data['student_id']         = $id;
                $data['title']              = $this->input->post('title');
                if ($this->input->post('description') != null) {
                    $data['description']        = $this->input->post('description');
                }
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
                if ($this->input->post('description') != null) {
                  $data['description']        = $this->input->post('description');
                }
                $data2['payment_type']      =  'income';
                $data2['method']            =   $this->input->post('method');
                $data2['amount']            =   $this->input->post('amount_paid');
                $data2['timestamp']         =   strtotime($this->input->post('date'));
                $data2['year']               =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('payment' , $data2);
            }
            
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?accountant/student_payment', 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');
            $data['title']              = $this->input->post('title');
            if ($this->input->post('description') != null) {
                $data['description']        = $this->input->post('description');
            }
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            
            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?accountant/income', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
           if ($this->input->post('description') != null) {
                $data['description']        = $this->input->post('description');
            }
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
            redirect(base_url() . 'index.php?accountant/income/', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/income', 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**********ACCOUNTING********************/
    function income($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'income';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data); 
    }

    function student_payment($param1 = '' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'student_payment';
        $page_data['page_title'] = get_phrase('create_student_payment');
        $this->load->view('backend/index', $page_data); 
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            if ($this->input->post('description') != null) {
               $data['description']         =   $this->input->post('description');
            }
            
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?accountant/expense', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            if ($this->input->post('description') != null) {
               $data['description']         =   $this->input->post('description');
            }
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?accountant/expense', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/expense', 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data); 
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?accountant/expense_category');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?accountant/expense_category');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/expense_category');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = get_phrase('expense_category');
        $this->load->view('backend/index', $page_data);
    }
    
    // MANAGE OWN PROFILE AND CHANGE PASSWORD
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['username'] = $this->input->post('username');

            $validation = accountant_username_validation_for_edit($data['username'], $this->session->userdata('accountant_id'), 'accountant');
            if ($validation == 1) {
                $this->db->where('accountant_id', $this->session->userdata('accountant_id'));
                $this->db->update('accountant', $data);
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_username_is_not_available'));
            }
            redirect(base_url() . 'index.php?accountant/manage_profile/', 'refresh');
        }

        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));
            
            $current_password = $this->db->get_where('accountant', array(
                'accountant_id' => $this->session->userdata('accountant_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('accountant_id', $this->session->userdata('accountant_id'));
                $this->db->update('accountant', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?accountant/manage_profile/', 'refresh');
        }
        
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('accountant', array(
            'accountant_id' => $this->session->userdata('accountant_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**Username validation check **/
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

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Manage Employee
     */
    function employee($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

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

            redirect(base_url() . 'index.php?accountant/employee/', 'refresh');
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

            redirect(base_url() . 'index.php?accountant/employee/', 'refresh');
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
            redirect(base_url() . 'index.php?accountant/employee/', 'refresh');
        }

        $page_data['employees']  = $this->db->get('employee')->result_array();
        $page_data['page_name']  = 'employee';
        $page_data['page_title'] = get_phrase('manage_employee');
        $this->load->view('backend/index', $page_data);

    }

    /**
     * @param string $param1
     * IMPORT EMPLOYEE CSV
     */
    function employee_import($param1 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

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
                redirect(base_url() . 'index.php?accountant/employee', 'refresh');
            }else {
                $this->session->set_flashdata('error_message', get_phrase('something_went_wrong'));
            }
        }

        $page_data['page_name']  = 'employee_import';
        $page_data['page_title'] = get_phrase('import_employee_data');
        $this->load->view('backend/index', $page_data);
    }

    function generateEmployeeCode()
    {
        $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 7; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Add Employee Bank Details
     */
    function bank_details($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'add') {

            $data['staff_type'] = $this->input->post('staff_type');      //(e.g. teacher, accountant, etc)
            $data['staff_id']   = $this->input->post('staff_id');  //represents staff name
            $data['bank_id']    = $this->input->post('bank_id');
            $data['branch']     = $this->input->post('branch');
            $data['acct_no']    = $this->input->post('acct_no');

            $this->db->insert('bank_details', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?accountant/bank_details/', 'refresh');
        }

        if ($param1 == 'do_update') {

            $data['bank_id']    = $this->input->post('bank_id');
            $data['branch']     = $this->input->post('branch');
            $data['acct_no']    = $this->input->post('acct_no');

            $this->db->where('id', $param2);
            $this->db->update('bank_details', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?accountant/bank_details/', 'refresh');
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
            redirect(base_url() . 'index.php?accountant/bank_details/', 'refresh');
        }

        $page_data['bank_details'] = $this->db->get('bank_details')->result_array();
        $page_data['page_name']    = 'bank_details';
        $page_data['page_title']   = get_phrase('staff_bank_details');
        $this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Pay Head Master
     */
    function payHeadMaster($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'create') {
            $data['pay_head_name']  = $this->input->post('pay_head_name');
            $data['description']    = $this->input->post('description');
            $data['action']         = $this->input->post('action');

            $this->db->insert('pay_head', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?accountant/payHeadMaster', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['pay_head_name']  = $this->input->post('pay_head_name');
            $data['description']    = $this->input->post('description');
            $data['action']         = $this->input->post('action');

            $this->db->where('pay_head_id' , $param2);
            $this->db->update('pay_head' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            redirect(base_url() . 'index.php?accountant/payHeadMaster', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('pay_head_id' , $param2);
            $this->db->delete('pay_head');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/payHeadMaster', 'refresh');
        }

        $page_data['page_title']    = get_phrase('pay_head_type');
        $page_data['page_name']     = 'pay_head';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Payable Types
     */
    function payableTypes($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'create') {
            $data['payable_name']  = $this->input->post('payable_name');

            $this->db->insert('payable_types', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?accountant/payableTypes', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['payable_name']  = $this->input->post('payable_name');
            $this->db->where('payable_id' , $param2);
            $this->db->update('payable_types' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            redirect(base_url() . 'index.php?accountant/payableTypes', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payable_id' , $param2);
            $this->db->delete('payable_types');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/payableTypes', 'refresh');
        }

        $page_data['page_title']    = get_phrase('payable_types');
        $page_data['page_name']     = 'payable_type';
        $this->load->view('backend/index', $page_data);
    }


    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Salary Settings
     */
    function salarySettings($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'add') {
            $data['staff_type']  = $this->input->post('staff_type');
            $data['staff_id']    = $this->input->post('staff_id');
            $data['pay_head_id'] = $this->input->post('pay_head_id');
            $data['unit'] = $this->input->post('unit');
            $data['type'] = $this->input->post('type');

            $this->db->insert('salary_settings', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?accountant/salarySettings', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['pay_head_id'] = $this->input->post('pay_head_id');
            $data['unit'] = $this->input->post('unit');
            $data['type'] = $this->input->post('type');

            $this->db->where('id' , $param2);
            $this->db->update('salary_settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));

            redirect(base_url() . 'index.php?accountant/salarySettings', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('salary_settings');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/salarySettings', 'refresh');
        }

        $page_data['page_title']    = get_phrase('salary_settings');
        $page_data['page_name']     = 'salary_settings';
        $this->load->view('backend/index', $page_data);
    }

    /**
     * @param string $param1
     * @param string $param2
     * @param string $param3
     * Staff Salary
     */
    function staffSalary($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('accountant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'add') {
            $data['staff_type']  = $this->input->post('staff_type');
            $data['staff_id']    = $this->input->post('staff_id');
            $data['year']        = $this->input->post('year');
            $data['month']       = $this->input->post('month');
            $data['start_date']  = $this->input->post('start_date');
            $data['end_date']    = $this->input->post('end_date');


            $this->db->insert('staff_salary', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));

            redirect(base_url() . 'index.php?accountant/staffSalary', 'refresh');
        }

        if ($param1 == 'edit') {
            $data['year']        = $this->input->post('year');
            $data['month']       = $this->input->post('month');
            $data['start_date']  = $this->input->post('start_date');
            $data['end_date']    = $this->input->post('end_date');

            $this->db->where('id' , $param2);
            $this->db->update('staff_salary' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?accountant/staffSalary', 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('staff_salary');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?accountant/staffSalary', 'refresh');
        }

        $page_data['page_title']    = get_phrase('set_staff_salary');
        $page_data['page_name']     = 'staff_salary';
        $this->load->view('backend/index', $page_data);
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

    function get_lga($state_id)
    {
        $sections = $this->db->get_where('locals' , array(
            'state_id' => $state_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['local_id'] . '">' . $row['local_name'] . '</option>';
        }
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

}
















