<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //COMMON FUNCTION FOR SENDING SMS
    function send_sms($message = '' , $reciever_phone = '')
    {
        $active_sms_service = $this->db->get_where('settings' , array(
            'type' => 'active_sms_service'
        ))->row()->description;

        if ($active_sms_service == '' || $active_sms_service == 'disabled')
            return;

        if ($active_sms_service == 'clickatell') {
            $this->send_sms_via_clickatell($message , $reciever_phone );
        }
        if ($active_sms_service == 'twilio') {
            $this->send_sms_via_twilio($message , $reciever_phone );
        }
        if ($active_sms_service == 'msg91') {
            $this->send_sms_via_msg91($message , $reciever_phone );
        }
        if ($active_sms_service == 'ebulksms') {
            $this->send_sms_via_ebulksms($message , $reciever_phone );
        }
        if ($active_sms_service == 'bulksmsnigeria') {
            $this->send_sms_via_bulksmsnigeria($message , $reciever_phone );
        }
    }

    // SEND SMS VIA CLICKATELL API
    function send_sms_via_clickatell($message = '' , $reciever_phone = '') {

        $clickatell_user       = $this->db->get_where('settings', array('type' => 'clickatell_user'))->row()->description;
        $clickatell_password   = $this->db->get_where('settings', array('type' => 'clickatell_password'))->row()->description;
        $clickatell_api_id     = $this->db->get_where('settings', array('type' => 'clickatell_api_id'))->row()->description;
        $clickatell_baseurl    = "http://api.clickatell.com";

        $text   = urlencode($message);
        $to     = $reciever_phone;

        // auth call
        $url = "$clickatell_baseurl/http/auth?user=$clickatell_user&password=$clickatell_password&api_id=$clickatell_api_id";

        // do auth call
        $ret = file($url);

        // explode our response. return string is on first line of the data returned
        $sess = explode(":",$ret[0]);
        print_r($sess);echo '<br>';
        if ($sess[0] == "OK") {

            $sess_id = trim($sess[1]); // remove any whitespace
            $url = "$clickatell_baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";

            // do sendmsg call
            $ret = file($url);
            $send = explode(":",$ret[0]);
            print_r($send);echo '<br>';
            if ($send[0] == "ID") {
                echo "successnmessage ID: ". $send[1];
            } else {
                echo "send message failed";
            }
        } else {
            echo "Authentication failure: ". $ret[0];
        }
    }


    // SEND SMS VIA TWILIO API
    function send_sms_via_twilio($message = '' , $reciever_phone = '') {

        // LOAD TWILIO LIBRARY
        require_once(APPPATH . 'libraries/twilio_library/Twilio.php');


        $account_sid    = $this->db->get_where('settings', array('type' => 'twilio_account_sid'))->row()->description;
        $auth_token     = $this->db->get_where('settings', array('type' => 'twilio_auth_token'))->row()->description;
        $client         = new Services_Twilio($account_sid, $auth_token);

        $client->account->messages->create(array(
            'To'        => $reciever_phone,
            'From'      => $this->db->get_where('settings', array('type' => 'twilio_sender_phone_number'))->row()->description,
            'Body'      => $message
        ));

    }

    //SMS via msg91
    function send_sms_via_msg91($message = '' , $reciever_phone = '') {
      
        $authKey       = $this->db->get_where('settings', array('type' => 'msg91_authentication_key'))->row()->description;
        $senderId      = $this->db->get_where('settings', array('type' => 'msg91_sender_ID'))->row()->description;

        //Multiple mobiles numbers separated by comma
        $mobileNumber = $reciever_phone;

        //Your message to send, Add URL encoding here.
        $message = urlencode($message);

        //Define route
        $route = "default";
        //Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route
        );
        //API URL
        $url="http://api.msg91.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
    }

    //Send SMS via ebulk SMS API
    function send_sms_via_ebulksms($message = '' , $reciever_phone = '') {

        // LOAD E-BULK SMS LIBRARY
        require_once(APPPATH . 'libraries/Ebulk_sms.php');

        $username = $this->db->get_where('settings', array('type' => 'ebulk_sms_user'))->row()->description;
        $apikey   = $this->db->get_where('settings', array('type' => 'ebulk_sms_apikey'))->row()->description;
        $sender   = $this->db->get_where('settings', array('type' => 'sms_sender_title'))->row()->description;
        $json_url = "http://api.ebulksms.com:8080/sendsms.json";

        $sendername = substr($sender, 0, 11);
        $flash      = 0;

        if (get_magic_quotes_gpc()) {
            $msg = stripslashes($message);
        }

        $msg = substr($message, 0, 160);

        $client = $this->useJSON($json_url, $username, $apikey, $flash, $sendername, $msg, $reciever_phone);

    }

    //Send SMS via bulk sms nigeria
     function send_sms_via_bulksmsnigeria($message = '' , $reciever_phone = '') {

        $username = $this->db->get_where('settings', array('type' => 'bulksmsnigeria_user'))->row()->description;
        $password = $this->db->get_where('settings', array('type' => 'bulksmsnigeria_pass'))->row()->description;
        $sender   = $this->db->get_where('settings', array('type' => 'sms_sender_title'))->row()->description;
        
        $parameters = sprintf ("username=%s&password=%s&sender=%s&mobiles=%s&message=%s", urlencode ( $username ), urlencode ( $password ), urlencode ( $sender ), urlencode ( $reciever_phone ), urlencode ( $message ) );

        $responseString = $this->sendSMS2('http://portal.bulksmsnigeria.net/api/', $parameters);

    }

    //for ebulk sms 
    function useJSON($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {

        $gsm = array();
        $country_code = '234';
        $arr_recipient = explode(',', $recipients);
        foreach ($arr_recipient as $recipient) {
            $mobilenumber = trim($recipient);
            if (substr($mobilenumber, 0, 1) == '0'){
                $mobilenumber = $country_code . substr($mobilenumber, 1);
            }
            elseif (substr($mobilenumber, 0, 1) == '+'){
                $mobilenumber = substr($mobilenumber, 1);
            }
            $generated_id = uniqid('int_', false);
            $gsm['gsm'][] = array('msidn' => $mobilenumber, 'msgid' => $generated_id);
        }
        $message = array(
            'sender' => $sendername,
            'messagetext' => $messagetext,
            'flash' => "{$flash}",
        );
     
        $request = array('SMS' => array(
                'auth' => array(
                    'username' => $username,
                    'apikey' => $apikey
                ),
                'message' => $message,
                'recipients' => $gsm
        ));
        $json_data = json_encode($request);
        if ($json_data) {
            $response = $this->doPostRequest($url, $json_data, array('Content-Type: application/json'));
            $result = json_decode($response);
            return $result->response->status;
        } else {
            return false;
        }

    }

    //Function to connect to SMS sending server using HTTP POST -> for ebulk sms
    function doPostRequest($url, $data, $headers = array('Content-Type: application/x-www-form-urlencoded')) {
        $php_errormsg = '';
        if (is_array($data)) {
            $data = http_build_query($data, '', '&');
        }
        $params = array('http' => array(
                'method' => 'POST',
                'content' => $data)
        );
        if ($headers !== null) {
            $params['http']['header'] = $headers;
        }
        $ctx = stream_context_create($params);
        $fp = fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            return "Error: gateway is inaccessible";
        }
        //stream_set_timeout($fp, 0, 250);
        try {
            $response = stream_get_contents($fp);
            if ($response === false) {
                throw new Exception("Problem reading data from $url, $php_errormsg");
            }
            return $response;
        } catch (Exception $e) {
            $response = $e->getMessage();
            return $response;
        }
    }

    function sendSMS2($apiurl, $params) {
        /**
         * @param string $apiurl
         * @param string $params
         * @return string
         */

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $apiurl );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $response = curl_exec ( $ch );
        return $response;

    }

}
