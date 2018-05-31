<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_add_bank_details/');" 
                class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_staff_bank_details');?>
                </a> 
<br>

<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">

            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_staff_bank_details');?></span>
                </a>
            </li>

            <li>
                <a href="#banks" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('banks');?></span>
                </a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">

                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('sn');?></div></th> 
                            <th><div><?php echo get_phrase('staff_role');?></div></th>        <th><div><?php echo get_phrase('staff_name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('bank');?></div></th>
                            <th><div><?php echo get_phrase('acct_no');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                            $bank_details = $this->db->get('bank_details' )->result_array();

                            $i = 1;
                            foreach($bank_details as $row):
                        ?>

                        <tr>
                            <td><?php echo $i++;?></td>

                            <td><?php echo $row['staff_type'];?></td>

                            <?php 
                                if($row['staff_type'] == 'teacher'){
                            ?>
                            
                            <td>
                                <?php
                                    echo $this->db->get_where('teacher' , array(
                                        'teacher_id' => $row['staff_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <?php }elseif ($row['staff_type'] == 'accountant') {

                            ?>

                            <td>
                                <?php
                                    echo $this->db->get_where('accountant' , array(
                                        'accountant_id' => $row['staff_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <?php 

                            }elseif($row['staff_type'] == 'librarian') {

                            ?>

                            <td>
                                <?php
                                    echo $this->db->get_where('librarian' , array(
                                        'librarian_id' => $row['staff_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <?php
                                
                            }else { ?>

                            <td>
                                <?php
                                    echo $this->db->get_where('employee' , array(
                                        'emp_id' => $row['staff_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <?php } ?>
                            <!--end staff type -->

                            <td>
                                <?php
                                    echo $this->db->get_where('banks' , array(
                                        'id' => $row['bank_id']
                                    ))->row()->name;
                                ?>
                            </td>

                            <td>
                                <?php echo $row['acct_no']; ?>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                         
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_bank_details_edit/<?php echo $row['id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>

                                        <li class="divider"></li>

                                        <li>
                                          <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/bank_details/delete/<?php echo $row['id'];?>');">
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

            $banks = $this->db->get('banks')->result_array();
            foreach ($banks as $row):

        ?>

            <div class="tab-pane" id="banks">

                <table class="table table-bordered datatable" id="table_bank">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('sn');?></div></th>                           
                            <th><div><?php echo get_phrase('name');?></div></th>
                            
                            <!--<th><div><?php echo get_phrase('options');?></div></th>-->
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                            $banks = $this->db->get('banks' )->result_array();

                            $i = 1;
                            foreach($banks as $row):?>

                        <tr>

                            <td><?php echo $i++;?></td>

                            <td>
                                <?php
                                    echo $this->db->get_where('banks' , array(
                                        'id' => $row['id']
                                    ))->row()->name;
                                ?>
                            </td>
                          
                            <!--<td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">                               
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_bank_edit/<?php echo $row['id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>-->
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
       
        </div>


    </div>
</div>



<!--  DATA TABLE EXPORT CONFIGURATIONS -->
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
                        "fnSetText"    : "Press 'esc' to return",
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

<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var datatable = $("#table_bank").dataTable({
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
                        "fnSetText"    : "Press 'esc' to return",
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
