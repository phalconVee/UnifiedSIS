<?php
$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
$system_logo        =   '<img src="'.base_url().'"uploads/logo.png"  style="max-height:60px;"/>';
$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
$account_type       =	$this->session->userdata('login_type');
$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
$running_year 		=   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
$school_title       =   $this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
$address            =   $this->db->get_where('settings' , array('type'=>'address'))->row()->description;
$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
$exam_name  		= 	$this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
$section_name  		= 	$this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
?>

<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
    <title>
        <?=$page_title?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="BIG School ERP" />
    <meta name="description" content="Intellisense Technology Africa" />
    <meta name="author" content="Henry Ugochukwu" />

    <link rel="shortcut icon" href="<?=base_url();?>assets/images/favicon-4.png">

    <link rel="stylesheet" href="<?=base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-icons/entypo/css/entypo.css">
    <link href="<?=base_url();?>assets/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700">

    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-core.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/neon-theme.css">

    <script src="<?=base_url();?>assets/js/jquery-1.11.0.min.js"></script>

    <style>
        table #header-tb {
            border: 1px solid #CCC;
            border-collapse: collapse;
        }

        #header-tb td, th {
            border: none;
        }

        table #main-tb tr {
            border: 1px solid #000;
        }

        #main-tb td, th {
            font-weight: 600;
        }

        #main-tb th {
            width: 20px;
            margin-top: -100px;
        }

        #main-tb td {
            height: 35px;
        }

        #rotate {
            -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
            -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
            -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
            filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
            -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
            height: 150px;
            border: 1px solid #000;
        }

        table #table-3 {
            height: 1px;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>

            <div class="col-md-10">

                <table id="header-tb" border="1" style="width: 100%; height: 50px;">
                    <tr >
                       <th>
                           <img src="<?php echo base_url();?>image.php/<?=base_url();?>uploads/logo.png?width=100&height=100&cropratio=1:1&image=<?=base_url();?>uploads/logo.png" />
                       </th>
                       <th style="text-align: center;">
                           <h3>St. Patricks Model Schools, Umuahia</h3>
                           <span>Saint Patrick's Model Crescent Road, off Agbama Upstair Line, World Bank
                            Housing Estate Umuahia, Abia State. Nigeria</span>
                           <h4>REPORT SHEET FOR 2017/2018 ACADEMIC SESSION</h4>
                       </th>
                       <th>
                           <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student', $student_id);?>?width=100&height=100&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student', $student_id);?>" class="img-circle"/>
                       </th>
                    </tr>
                </table>

                <table id="header-tb" border="1" style="width: 100%; height: 25px;margin-top: 2px;color: #000;">
                    <tr>
                        <td>NAME:</td>
                        <td><strong>CHINENYE OKAFOR</strong></td>
                        <td>TERM:</td>
                        <td><strong>FIRST TERM</strong></td>
                        <td>REG NO:</td>
                        <td><strong>2010364133</strong></td>
                        <td>SESSION:</td>
                        <td><strong>2016-2017</strong></td>
                    </tr>
                    <tr>
                        <td>CLASS:</td>
                        <td><strong> Class SS 2 Q</strong></td>
                        <td>NO. IN CLASS:</td>
                        <td><strong>18</strong></td>
                        <td>AVERAGE:</td>
                        <td><strong>0.00%</strong></td>
                        <td>POSITION:</td>
                        <td><strong>0<sup>th</sup></strong></td>
                    </tr>
                </table>

                <table id="main-tb" border="1" style="width: 100%; margin-top: 28px;color: #000;text-align: center;">
                    <thead>
                        <tr style="border: 1px solid #000;">
                            <th class="text-center" width="40%">
                                Subject
                            </th>
                            <th class="text-center">1<sup>st</sup> C.A</th>
                            <th class="text-center">2<sup>nd</sup> C.A</th>
                            <th class="text-center">3<sup>rd</sup> C.A</th>
                            <th class="text-center">Total C.A (40%)</th>
                            <th class="text-center">Exam (60%)</th>
                            <th class="text-center">Total (100%)</th>
                            <th class="text-center">Grade </th>
                            <th class="text-center">Remark</th>
                            <th class="text-center">No. of students in subject class </th>
                            <th class="text-center">Highest In Class</th>
                            <th class="text-center">Lowest In Class</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dddd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                            <td>dd</td>
                        </tr>
                    </tbody>

                </table>

                <div style="text-align: center;color: #000;font-weight: 500;">
                    <table border="1" id="table-3" style="padding: 8px; height: 12px; margin-top: 5px;">
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>GRADING</th>
                            <th></th>
                        </tr>
                        <tbody>
                        <tr>
                            <td>95 - 100</td>
                            <td>A+</td>
                            <td>Excellent in Knowledge</td>
                        </tr>
                        <tr>
                            <td>80 - 94</td>
                            <td>A</td>
                            <td>Excellent</td>
                        </tr>

                        <tr>
                            <td>70 -79</td>
                            <td>B</td>
                            <td>Very Good</td>
                        </tr>

                        <tr>
                            <td>60 -69</td>
                            <td>C</td>
                            <td>Good</td>
                        </tr>

                        <tr>
                            <td>45 - 59</td>
                            <td>D</td>
                            <td>Fairly Good</td>
                        </tr>

                        <tr>
                            <td>30 - 44</td>
                            <td>E</td>
                            <td>Poor</td>
                        </tr>

                        <tr>
                            <td>0 - 29</td>
                            <td>F</td>
                            <td>Very Poor</td>
                        </tr>

                        </tbody>

                    </table>
                </div>

                <table id="header-tb" border="1" style="width: 100%; height: 25px;margin-top: 5px;color: #000;">
                    <tr>
                        <td>Reg No:</td>
                        <td><strong>2017/1367</strong></td>
                        <td>Days Opened:</td>
                        <td><strong>60</strong></td>
                        <td>Days Present:</td>
                        <td><strong>0</strong></td>
                        <td>Days Absent:</td>
                        <td><strong>0</strong></td>
                    </tr>
                    <tr>
                        <td>Total Marks Obtained:</td>
                        <td><strong> 323</strong></td>
                        <td>No. of Subjects Taken:</td>
                        <td><strong>5</strong></td>
                        <td>Vacation Date:</td>
                        <td><strong>03/16/2018</strong></td>
                        <td>Resumption Date:</td>
                        <td><strong>N/A</strong></td>
                    </tr>
                </table>

                <table class="table table-bordered" border="1" style="width: 100%; height: 25px;margin-top: 5px;color: #000;">
                    <thead>
                    <tr>
                        <td class="text-center" style="text-align: center;background-color: #ccc; color: #000;" width="20"><strong>Result Status:</strong></td>
                        <td class="text-center" width="80" style="color: #000;">&nbsp;
                            <?php
                            //echo $pass_status;
                            if($pass_status == 'FAILED')
                                echo 'FAILED';
                            else
                                echo 'PASSED';
                            ?>
                        </td>
                    </tr>
                    </thead>
                </table>

                <div class="margin"></div><br>

                <div class="row">
                    <div class="col-md-12">

                        <table width="100%" class="table responsive" style="color: #000;">
                            <tr>
                                <td>TEACHER: ______________________________________</td>
                                <td>PRINCIPAL: ______________________________________</td>
                                <td>PARENT: ______________________________________</td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>

            <div class="col-md-1"></div>
        </div>
    </div>

</body>

<script src="<?=base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?=base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?=base_url();?>assets/js/bootstrap.js"></script>

</html>