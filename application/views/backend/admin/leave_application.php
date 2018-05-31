
            <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_leave_add/');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('new_application');?>
                </a> 

                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('sn');?></div></th>
                         	<th><div><?php echo get_phrase('designation');?></div></th>
                            <th><div><?php echo get_phrase('staff_name');?></div></th>
                            <th><div><?php echo get_phrase('leave_category');?></div></th>
                            <th><div><?php echo get_phrase('from');?></div></th>
                            <th><div><?php echo get_phrase('to');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                                $application = $this->db->get('leave_application' )->result_array();

                                $i = 1;
                                foreach($application as $row):?>
                        <tr>
                            <td><?php echo $i++;?></td>

                            <td><?php echo $row['staff_type'];?></td>

                            <td>
                                <?php
                                    echo $this->db->get_where('teacher' , array(
                                        'teacher_id' => $row['staff_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <td>
                            	<?php 
                            	echo $this->db->get_where('leave_category', array('id' => $row['leave_category_id']))->row()->category_name; 
                            	?>                          		
                            </td>    

                            <td><?php echo $row['from'];?></td>

                            <td><?php echo $row['to'];?></td>

                            <td>
                            	<?php $status = $row['status'];?>
                            	<?php if($status == '1'){ ?>
                            		<a href="javascript:;" onclick="" class="btn btn-sm btn-success">Approved</a>
                            	<?php }elseif($status == '2'){ ?>
                            		<a href="javascript:;" onclick="" class="btn btn-sm btn-danger">Rejected</a>
                            	<?php }elseif($status == '3'){ ?>
                            		<a href="javascript:;" onclick="" class="btn btn-sm btn-warning">Awaiting Approval</a>
                            	<?php } ?>                            		
                            		
                            </td>

                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    	<li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_leave_profile/<?php echo $row['id'];?>');">
                                                <i class="entypo-eye"></i>
                                                    <?php echo get_phrase('view');?>
                                                </a>
                                        </li>                                        
                                        
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_leave_edit/<?php echo $row['id'];?>');">
                                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                        				</li>

                                        <li class="divider"></li>                                        
                                        
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/leaveApplication/delete/<?php echo $row['id'];?>');">
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
						"mColumns": [1,2]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1,2]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(0, false);
							datatable.fnSetColumnVis(3, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(0, true);
									  datatable.fnSetColumnVis(3, true);
								  }
							});
						},
						
					},
				]
			},
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

