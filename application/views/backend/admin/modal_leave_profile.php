<?php
$leave_info	= $this->db->get_where('leave_application' , array('id' => $param2))->result_array();

foreach($leave_info as $row):?>

<div class="profile-env">
	
	<header class="row">
				
		<div class="col-sm-9">
			<h3>Leave Application Reason</h3>
		</div>
				
	</header>

    <br><br>
	
	<section class="profile-info-tabs">
		
		<div class="row">
			
			<div class="">
            		<br>
                <table class="table table-bordered">                
                   
                    <?php if($row['staff_id']):?>

                    <tr>
                        <td><?php echo get_phrase('leave_category');?></td>
                        <td>
                            <b><?php echo $this->db->get_where('leave_category' , array('id' => $row['id']))->row()->category_name;?>                                
                            </b>
                        </td>
                    </tr>
                    <?php endif;?>
                
                    <?php if($row['from'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('from');?></td>
                        <td><b><?php echo $row['from'];?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if($row['to'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('to');?></td>
                        <td><b><?php echo $row['to'];?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if($row['reason'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('reason');?></td>
                        <td><b><?php echo $row['reason'];?></b></td>
                    </tr>
                    <?php endif;?>              
                                        
                </table>
			</div>                
            
		</div>	


	</section>

    <?php $current_date = strtotime(date("m/d/Y")); $to = strtotime($row['to']);  ?>

    <?php if($current_date <= $to){ ?>

    <?php if($row['status'] == '3'){ ?>
        <div class="row">
            <table style="margin-left: 15px;">
                <tr>
                    <td><a href=javascript:; onclick="change_leave_status(<?=$row['id']?>, 1);" class="btn btn-success">Approve</a></td>
                    <td>&nbsp;</td>
                    <td><a href=javascript:; onclick="change_leave_status(<?=$row['id']?>, 2)" class="btn btn-danger">Reject</a></td>                
                </tr>
            </table>       
        </div>
    <?php }elseif($row['status'] == '2'){ ?>

        <div class="row">
            &nbsp;       
        </div>

    <?php }else{ ?>
        <table style="margin-left: 15px;">
            <tr>
                <td><button class="btn btn-info">Approved</button></td>
            </tr>
        </table>
    <?php } ?>

<?php }else{ ?>

 <?php //if($row['to'] >= $current_date): ?>
    <table style="margin-left: 15px;">
        <tr>
            <td><button class="btn btn-info">Completed</button></td>
        </tr>
    </table>

  <?php } ?>

    	
</div>


<?php endforeach;?>

<script type="text/javascript">
    function change_leave_status(id, status) {

        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/leaveApplication/change_status/' + id + '/' + status,
            success: function(response)
            {
               toastr.success("Leave Status Changed");
               window.location = "<?=base_url();?>index.php?admin/leaveApplication";
            }
        });
    }
</script>