<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paystack extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Include composer autoloader if not already done once
        include_once APPPATH . 'vendor/autoload.php';

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function index()
    {
        $this->redirectToGateway();
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        $secret_key = $this->db->get_where('settings' , array('type' =>'paystack_secret_key'))->row()->description;
        $due_val    = $this->input->post('due');
        //multiply due by 100 to convert to kobo before parsing to paystack
        $due        = $due_val*100;
        $email      = $this->input->post('email');
        $ref        = 'STP-' . strtoupper(uniqid());

        $student_id  = $this->input->post('student_id');
        $invoice_id  = $this->input->post('invoice_id');
        $amount      = $this->input->post('amount');
        $amount_paid = $this->input->post('amount_paid');

        $paystack = new \Yabacon\Paystack($secret_key);
        try
        {
            $tranx = $paystack->transaction->initialize([
                'amount' => $due,        // in kobo
                'email'  => $email,         // unique to customers
                'reference' => $ref,        // unique to transactions
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        // store transaction reference so we can query in case user never comes back
        // perhaps due to network issue
        $this->handleGatewayCallback($tranx->data->reference, $student_id, $invoice_id, $amount, $amount_paid, $due_val);

        // redirect to page so User can pay
        header('Location: ' . $tranx->data->authorization_url);
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback($ref, $student_id, $invoice_id, $amount, $amount_paid, $due_val)
    {
        $paymentDetails = array(
          'reference'  => $ref,
          'student_id' => $student_id,
          'invoice_id' => $invoice_id,
          'amount'      => $amount,
          'amount_paid' => $amount_paid,
          'due' => $due_val
        );

        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        $this->db->insert('pay_reference', $paymentDetails);
    }

   function verify()
    {
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
            die('No reference supplied');
        }

        //retrieve student, invoice id, and amount paid from table using matching ref
        $get_invoice_id  = $this->db->get_where('pay_reference', array('reference' => $reference))->row()->invoice_id;
        $get_student_id  = $this->db->get_where('pay_reference', array('reference' => $reference))->row()->student_id;
        $get_amount_paid = $this->db->get_where('pay_reference', array('reference' => $reference))->row()->amount_paid;

        $due_pay_reference  = $this->db->get_where('pay_reference', array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->due;
        $due_invoice  = $this->db->get_where('invoice', array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->due;
        //$amount_paid   = $this->db->get_where('pay_reference', array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->amount_paid;

        //obtain paystack secret key from db::table->settings
        $secret_key = $this->db->get_where('settings' , array('type' =>'paystack_secret_key'))->row()->description;

        // initiate the Library's Paystack Object
        $paystack = new Yabacon\Paystack($secret_key);
        try
        {
            // verify using the library
            $tranx = $paystack->transaction->verify([
                'reference' => $reference, //unique to transactions
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        if ('success' === $tranx->data->status) {

            $new_amount_paid = $get_amount_paid + $due_invoice;
            $new_due         = $due_pay_reference - $due_invoice;

            //array to insert new payment details as done in admin/invoice/take_payment/{student_id}
            $data['invoice_id']   =   $get_invoice_id;
            $data['student_id']   =   $get_student_id;
            $data['title']        =   $this->db->get_where('payment' , array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->title;
            $data['description']  =   $this->db->get_where('payment' , array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->description;
            $data['payment_type'] =   'income';
            $data['method']       =   $this->db->get_where('payment' , array('student_id' => $get_student_id, 'invoice_id' => $get_invoice_id))->row()->method;
            $data['amount']       =   $due_invoice;
            $data['timestamp']    =   strtotime(date("m/d/Y"));
            $data['year']         =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);


            //array to changes into invoice
            $updateData = array(
              'payment_details'   => "",
              'payment_timestamp' => strtotime(date("m/d/Y")),
              'payment_method'    => 'paystack',
              'status'            => 'paid',
              'due'               => $new_due,
              'amount_paid'       => $new_amount_paid
            );

            $this->db->where('invoice_id' , $get_invoice_id);
            $this->db->update('invoice', $updateData);

            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value
            // echo 'Transaction successful '.$get_student_id;

            $this->session->set_flashdata('flash_message', get_phrase('payment_successfully_completed'));
            redirect(base_url() . 'index.php?parents/invoice/'.$get_student_id, 'refresh');
        }
    }

}