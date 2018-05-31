<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo get_phrase('scratch_card_list');?>
                </a>
            </li>

            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_scratch_cards');?>
                </a>
            </li>

            <li>
                <a href="#remove-all" data-toggle="tab"><i class="entypo-trash"></i>
                    <?php echo get_phrase('remove_all_scratch_cards');?>
                </a>
            </li>
        </ul>
        <!------CONTROL TABS END------>

        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                    <tr>
                        <th><div>#</div></th>
                        <th><div><?php echo get_phrase('type');?></div></th>
                        <th><div><?php echo get_phrase('pin');?></div></th>
                        <th><div><?php echo get_phrase('assigned');?></div></th>
                        <th><div><?php echo get_phrase('assigned_to');?></div></th>
                        <th><div><?php echo get_phrase('term');?></div></th>
                        <th><div><?php echo get_phrase('year');?></div></th>
                        <th style="display:none;"><div><?php echo get_phrase('action');?></div></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php $count = 1;foreach($cards as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>

                            <?php if($row['type'] == '1'){ ?>
                                <td>Result Checker</td>
                            <?php }elseif($row['type'] == '2'){ ?>
                                <td>School Fee</td>
                            <?php }else{ ?>
                                <td>Admission</td>
                            <?php } ?>

                            <td><?php echo $row['pin'];?></td>

                            <td>
                                <?php
                                if($row['assigned'] == '1') { echo '<span class="badge badge-danger">Yes</span>'; }else{ echo '<span class="badge badge-success">No</span>'; }
                                ?>
                            </td>

                            <td>
                                <?php
                                $student_id =  $row['student_id'];
                                if($student_id == '0') {
                                    echo null;
                                }else{
                                    $name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
                                    $other_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->other_name;
                                    echo $name.' '.$other_name;
                                }

                                ?>
                            </td>

                            <td>
                                <?php 
                                    $ex_id =  $row['exam_id'];

                                    $term_name = $this->db->get_where('exam' , array('exam_id' => $ex_id))->row()->name;

                                    echo $term_name;
                                ?>
                            </td>

                            <td><?php echo $row['year']; ?></td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- ASSIGN LINK -->
                                        <?php if($row['assigned'] != '1') { ?>
                                            <li>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_assign_pin/<?php echo $row['card_id'];?>');" >
                                                    <i class="entypo-forward"></i>
                                                    <?php echo get_phrase('assign');?>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/scratch_cards/delete/<?php echo $row['card_id'];?>');">
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
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">

                    <?php echo form_open(base_url() . 'index.php?admin/scratch_cards/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>

                    <div class="padded">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('school_session');?></label>

                            <div class="col-sm-5">
                                <select name="year" class="form-control selectboxit">
                                    <?php $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;?>
                                    <option value="" disabled="true"><?php echo get_phrase('select_running_session_for_the_scratched_cards');?></option>
                                    <?php for($i = 0; $i < 10; $i++):?>
                                        <option value="<?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>"
                                            <?php if($running_year == (2016+$i).'-'.(2016+$i+1)) echo 'selected';?>>
                                            <?php echo (2016+$i);?>-<?php echo (2016+$i+1);?>
                                        </option>
                                    <?php endfor;?>
                                </select>

                            </div>

                        </div>

                         <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('term');?></label>

                            <div class="col-sm-5">
                                <select name="exam_id" class="form-control selectboxit">

                                    <?php $running_term = $this->db->get('exam')->result_array();?>

                                    <option value="" disabled="true"><?php echo get_phrase('select_running_term_for_usage');?></option>
                                    <?php foreach($running_term as $term):?>
                                        <option value="<?=$term['exam_id']?>">
                                            <?php echo $term['name'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('cards_usage');?></label>
                            <div class="col-sm-5">
                                <select name="type" class="form-control selectboxit">
                                    <option value="" disabled="true"><?php echo get_phrase('how_should_the_scratched_cards_be_used');?></option>
                                    <option value="1"><?php echo get_phrase('result_checker');?></option>
                                    <option value="2"><?php echo get_phrase('school_fees');?></option>
                                    <option value="3"><?php echo get_phrase('admission');?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('cards_duration');?></label>
                            <div class="col-sm-5">
                                <select name="duration" class="form-control selectboxit">
                                    <option value="" disabled="true"><?php echo get_phrase('how_many_times_should_the_cards_be_used_before_expiration');?></option>
                                    <option value="1"><?php echo get_phrase('one');?></option>
                                    <option value="2"><?php echo get_phrase('two');?></option>
                                    <option value="3"><?php echo get_phrase('three');?></option>
                                    <option value="4"><?php echo get_phrase('four');?></option>
                                    <option value="5"><?php echo get_phrase('five');?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('total_cards');?></label>
                            <div class="col-sm-5">
                                <input type="number" min="1" max="1000" placeholder="Example: 20, 30,40, 60, 80, 100, 120, 300, etc" class="form-control" name="total" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('price_of_cards');?></label>
                            <div class="col-sm-5">
                                <input type="number" min="1" class="form-control" placeholder="Example: 20, 30,40, 60, 80, 100, 120, 300, etc" name="price" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                            </div>
                        </div>

                        </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('generate');?></button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
            <!----CREATION FORM ENDS-->

            <!----REMOVE ALL SCRATCH CARDS STARTS---->
            <div class="tab-pane box" id="remove-all" style="padding: 5px">
                <div class="box-content">
                    <div class="padded">

                        <div class="ccol-sm-12">
                            <blockquote class="blockquote-blue">

                                <p>
                                    Removing all scratch cards will automatically delete existing card records from the database. Please make sure that the events
                                    that requires the usage of these cards are no longer valid.
                                </p>
                            </blockquote>
                        </div>


                        <div class="form-group">

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <?php
                                        $check_records = $this->db->get('cards')->result_array();
                                        if(!empty($check_records)) {
                                    ?>
                                    <a href="<?php echo base_url();?>index.php?admin/scratch_cards/delete_all" class="btn btn-info">
                                        <i class="entypo-trash"></i>
                                        <?php echo get_phrase('delete_all');?>
                                    </a>
                                    <?php }else{ ?>
                                    <button type="button" class="btn btn-inverse">No card record(s) found</button>
                                    <?php } ?>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <!--REMOVE ALL SCRATCH CARDS ENDS-->




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
                        "mColumns": [0, 1, 2, 4, 5]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 1, 2, 4, 5]
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
