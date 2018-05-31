<?php
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
    $system_logo        = '<img src="'.base_url().'"uploads/logo.png"  style="max-height:60px;"/>';
	$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
	$account_type       =	$this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
	$running_year 		  =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;

  $school_title       =   $this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
?>

<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
	<title>
        <?php echo $page_title;?> | <?php echo $school_title;?>
    </title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="BIG School ERP" />
	<meta name="description" content="Intellisense Technology Africa" />
	<meta name="author" content="Henry Ugochukwu" />

	<?php include 'includes_top.php';?>

    <style type="text/css">
        <!--
        .style2 {color: #FF0000; font-size: 24px;}
        .style5 {color: #0066FF; font-size: 18px; }
        -->
    </style>

    <style type="text/css">
      #chart-container {
        width: 640px;
        height: auto;
      }

      .chart-legend li span {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
      }

      .privacy_loader {
        background: url('<?=base_url();?>assets/images/fs-boxer-loading.gif') no-repeat;
        background-size: 15px;
        float: right;
        width: 15px;
        height: 15px;
        margin-top: 1px;
      }
    </style>


    
</head>


<body class="page-body <?php if ($skin_colour != '') echo 'skin-' . $skin_colour;?>" >

	<div class="page-container <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>

		<?php if($page_name == 'student_bulk_add' || $page_name == 'attendance_report_view' || $page_name == 'student_id_card' || $page_name == 'teacher_id_card' || $page_name == 'submit_term_result') echo 'sidebar-collapsed';?>" >

        <!-- side bar nav menu -->
        <?php include $account_type.'/navigation.php';?>
        <!-- end -->

	  <div class="main-content">
		
			<?php include 'header.php';?>

           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				<?php echo $page_title;?>
           </h3>

               <p align="center">
                 <?php include $account_type.'/'.$page_name.'.php';?>
               </p>

               <p align="center">
                     <?php include 'footer.php';?>
               </p>

	  </div>

		<?php //include 'chat.php';?>
        	
	</div>
    <?php include 'modal.php';?>

    <?php include 'includes_bottom.php';?>


</body>
</html>