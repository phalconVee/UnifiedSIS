<?php
$student_info	=	$this->db->get_where('enroll' , array(
    'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
    ))->result_array();
foreach($student_info as $row):?>

<div class="profile-env">
	
	<header class="row">
		
		<div class="col-sm-3">
			
			<a href="#" class="profile-picture">

                 <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>?width=120&height=120&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-responsive img-circle" />

			</a>
			
		</div>
		
		<div class="col-sm-9">
			
			<ul class="profile-info-sections">
				<li style="padding:0px; margin:0px;">
					<div class="profile-name">
							<h3>
                                <?php echo $this->db->get_where('student' , array('student_id' => $param2))->row()->name;?>                     
                            </h3>
					</div>
				</li>
			</ul>
			
		</div>
		
		
	</header>
	
	<section class="profile-info-tabs">
		
		<div class="row">
			
			<div class="">
            		<br>
                <table class="table table-bordered">
                
                    <?php if($row['class_id'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('class');?></td>
                        <td><b><?php echo $this->crud_model->get_class_name($row['class_id']);?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if($row['section_id'] != '' && $row['section_id'] != 0):?>
                    <tr>
                        <td><?php echo get_phrase('section');?></td>
                        <td><b><?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;?></b></td>
                    </tr>
                    <?php endif;?>
                
                    <?php if($row['roll'] != ''):?>
                    <tr>
                        <td><?php echo get_phrase('roll');?></td>
                        <td><b><?php echo $row['roll'];?></b></td>
                    </tr>
                    <?php endif;?>
                    <tr>
                        <td><?php echo get_phrase('birthday');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->birthday;?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('gender');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->sex;?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('phone');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;?></b></td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('email');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email;?></b></td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('religion');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->religion;?></b></td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('nationality');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->nationality;?></b></td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('state');?></td>
                        <td>
                            <?php $state_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->state_id;?>

                            <?php if(empty($state_id)){ echo 'State not selected yet';}else{ ?>
                            <b><?php echo $this->db->get_where('states' , array('state_id' => $state_id))->row()->name;?></b>
                            <?php } ?>

                        </td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('lga');?></td>
                        <td>
                            <?php $local_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->local_id;?>

                            <?php if(empty($local_id)){ echo 'LGA not selected yet';}else{ ?>

                            <b><?php echo $this->db->get_where('locals' , array('local_id' => $local_id))->row()->local_name;?></b>

                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('address');?></td>
                        <td><b><?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->address;?></b>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo get_phrase('parent');?></td>
                        <td>
                            <b>
                                <?php 
                                    $parent_id = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                                    echo $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->name;
                                ?>
                            </b>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('parent_phone');?></td>
                        <td><b><?php echo $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;?></b></td>
                    </tr>
                    
                </table>
			</div>
		</div>		
	</section>
	
	
	
</div>


<?php endforeach;?>