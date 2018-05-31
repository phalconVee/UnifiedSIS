<hr />
<a href="<?php echo base_url();?>index.php?admin/student_add"
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_student');?>
    </a>
<br>

<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>
        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <li>
                <a href="#<?php echo $row['section_id'];?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('section');?> <?php echo $row['name'];?> ( <?php echo $row['nick_name'];?> )</span>
                </a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('admission_no');?></div></th>
                            <th><div><?php echo get_phrase('student_code');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $this->db->select('student.name, student.student_code, enroll.roll, enroll.enroll_code, enroll.student_id');
                        $this->db->from('student');
                        $this->db->where('enroll.class_id', $class_id);
                        $this->db->where('enroll.year', $running_year);
                        $this->db->join('enroll', 'enroll.student_id = student.student_id');
                        $this->db->order_by('student.name', 'ASC');
                        $students = $this->db->get()->result_array();

                        foreach($students as $row):?>
                        <tr>

                            <td><?php echo $row['roll'];?></td>
                            <td>
                                 <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>?width=30&height=30&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle"/>
                            </td>
                            <td>
                                <?php
                                    /*echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;*/
                                    echo $row['name'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $row['enroll_code'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    /*echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->student_code;*/
                                    echo $row['student_code'];
                                ?>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?admin/student_marksheet/<?php echo $row['student_id'];?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>
                                         
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_edit/<?php echo $row['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                          <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/delete_student/<?php echo $row['student_id'];?>/<?php echo $class_id;?>');">
                                            <i class="entypo-trash"></i>
                                              <?php echo get_phrase('delete');?>
                                          </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>


        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll');?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('admission_no');?></div></th>
                            <th><div><?php echo get_phrase('student_code');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $this->db->select('student.name, student.student_code, enroll.roll, enroll.enroll_code, enroll.student_id');
                        $this->db->from('student');
                        $this->db->where('enroll.class_id', $class_id);
                        $this->db->where('enroll.section_id', $row['section_id']);
                        $this->db->where('enroll.year', $running_year);
                        $this->db->join('enroll', 'enroll.student_id = student.student_id');
                        $this->db->order_by('student.name', 'ASC');
                        $students = $this->db->get()->result_array();

                        foreach($students as $row1):?>
                        <tr>

                            <td><?php echo $row1['roll'];?></td>

                            <td>
                                 <img src="<?php echo base_url();?>image.php/<?php echo $this->crud_model->get_image_url('student', $row1['student_id']);?>?width=30&height=30&cropratio=1:1&image=<?php echo $this->crud_model->get_image_url('student', $row1['student_id']);?>" class="img-circle"/>
                            </td>

                            <td>
                                <?php echo $row1['name'];?>
                            </td>
                            <td>
                                <?php
                                echo $row1['enroll_code'];
                                ?>
                            </td>
                            <td>
                                <?php echo $row1['student_code'];?>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="<?php echo base_url();?>index.php?admin/student_marksheet/<?php echo $row1['student_id'];?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row1['student_id'];?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>                                        

                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_edit/<?php echo $row1['student_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
        <?php endif;?>

        </div>


    </div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [

					{
						"sExtends": "xls",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);

							this.fnPrint( true, oConfig );

							window.print();

							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
								  }
							});
						}
					}
				]
			}
		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});

</script>
