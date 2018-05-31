<?php

$system_logo    = '<img src="'.base_url().'"uploads/logo.png" style="max-height:60px;"/>';
$system_address  =  $this->db->get_where('settings' , array('type'=>'address'))->row()->description;
$system_title   =  $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;

$student_info	=	$this->db->get_where('enroll' , array(
    'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
    ))->result_array();

foreach($student_info as $row):?>

<div class="profile-env printableArea">

    <center>
        <div class="row">
            <img src="uploads/logo.png" alt="logo" style="max-height:60px;"/>
        </div>

        <div class="row">
             <h4><?php echo $system_address ?></h4>
        </div>
        <div class="row">
             <h5><i>Motto:<?php echo $system_title ?></i></h5>
        </div>
    </center>
	
	<header class="row">
		
				
		<div class="col-sm-3">
			
			<a href="#" class="profile-picture">
                <img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" 
                    class="img-responsive img-circle" />
            </a>
			
		</div>

        <div class="col-sm-9">         
        </div>
		
		
	</header>
	
	<section class="profile-info-tabs">
		
		<div class="row">
			
			<div class="">
            		<!--<br>-->
                <table class="table responsive" style="margin-left: 2=25px;">

                     <tr>
                        <td><h3><?php echo get_phrase('name');?></h3></td>
                        <td><h3><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?></b></h3></td>
                    </tr>  
                                
                    <?php if($row['roll'] != ''):?>
                    <tr>
                        <td><h3><?php echo get_phrase('admission_no');?></h3></td>
                        <td><h3><b><?php echo $row['roll'];?></b></h3></td>
                    </tr>
                    <?php endif;?>
                   
                    <tr>
                        <td><h3><?php echo get_phrase('gender');?></h3></td>
                        <td><h3><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->sex;?></b></h3></td>
                    </tr>

                    <tr>
                        <td><h3><?php echo get_phrase('student_code');?></h3></td>
                        <td><h3><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->student_code;?></b></h3></td>
                    </tr>                  

                    
                </table>
			</div>
		</div>		
	</section>

    <center>
    <a href="javascript:void(0);" id="printButton" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print ID Card
        <i class="entypo-print"></i>
    </a>
</center>
	
	
	
</div>


<?php endforeach;?>

<script>
$(document).ready(function(){
    $("#printButton").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("div.printableArea").printArea( options );
    });
});
</script>