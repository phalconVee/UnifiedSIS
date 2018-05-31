<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        //Include composer autoloader if not already done once
        include_once APPPATH . 'vendor/autoload.php';
    }

    //this function will redirect to book service page
    public function index()
    {
        $this->paystack();
    }

    function paystack()
    {
        $secret_key = $this->db->get_where('settings' , array('type' =>'paystack_secret_key'))->row()->description;
        $amount = 45678;
        $email = 'phalcon.vee@gmail.com';
        $ref   = 'STP-' . strtoupper(uniqid());

        $paystack = new \Yabacon\Paystack($secret_key);
        try
        {
            $tranx = $paystack->transaction->initialize([
                'amount' => $amount,        // in kobo
                'email'  => $email,         // unique to customers
                'reference' => $ref,        // unique to transactions
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        // store transaction reference so we can query in case user never comes back
        // perhaps due to network issue
        //save_last_transaction_reference($tranx->data->reference);

        // redirect to page so User can pay
        header('Location: ' . $tranx->data->authorization_url);
    }

    function verify()
    {
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
            die('No reference supplied');
        }

        $secret_key = $this->db->get_where('settings' , array('type' =>'paystack_secret_key'))->row()->description;

        // initiate the Library's Paystack Object
        $paystack = new Yabacon\Paystack($secret_key);
        try
        {
            // verify using the library
            $tranx = $paystack->transaction->verify([
                'reference'=>$reference, // unique to transactions
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        if ('success' === $tranx->data->status) {
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value
            echo 'Transaction successful';
        }
    }

    function handle()
    {
        
        $this->db->query('SELECT enroll_code, COUNT(*) c FROM enroll GROUP BY enroll_code HAVING c > 1');

        $sql = $this->db->result_array();

        var_dump($sql);
    }
}
