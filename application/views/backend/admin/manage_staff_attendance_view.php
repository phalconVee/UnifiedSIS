<hr />

<?php echo form_open(base_url() . 'index.php?admin/staff_attendance_selector/'); ?>
<div class="row">

    <div class="col-md-3">
        <div class="form-group">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('designation');?></label>
            
            <select name="staff_type" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" onchange="return get_staff_names(this.value)" id = "type_selection">

              <option value=""><?php echo get_phrase('select');?></option>
              <option value="teacher" <?php if ($staff_type == 'teacher') echo 'selected'; ?>><?php echo get_phrase('teacher');?></option>

              <option value="accountant" <?php if ($staff_type == 'accountant') echo 'selected'; ?>><?php echo get_phrase('accountant');?></option>

              <option value="librarian" <?php if ($staff_type == 'librarian') echo 'selected'; ?>><?php echo get_phrase('librarian');?></option>

              <option value="employee" <?php if ($staff_type == 'employee') echo 'selected'; ?>><?php echo get_phrase('employee');?></option>
            </select>

        </div>
    </div>
    
    <!--<div id="section_holder">
    <div class="col-md-3">
        <div class="form-group">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('name');?></label>
            <select class="form-control selectboxit" name="staff_id">
                <option value=""><?php echo get_phrase('select_designation_first') ?></option>
            </select>
        </div>
    </div>
    </div>-->
    
    <div class="col-md-3">
        <div class="form-group">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date');?></label>
            <input type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
                value="<?php echo date("d-m-Y", $timestamp); ?>"/>
        </div>
    </div>

    <input type="hidden" name="year" value="<?php echo $running_year;?>">

    <div class="col-md-3" style="margin-top: 20px;">
        <button type="submit" id = "submit" class="btn btn-info"><?php echo get_phrase('manage_attendance');?></button>
    </div>

</div>
<?php echo form_close(); ?>

<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">

        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-chart-area"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('attendance_for'); ?> 
                <?php echo $staff_type; ?>                    
            </h3>

           
            <h4 style="color: #696969;">
                <?php echo date("d M Y", $timestamp); ?>
            </h4>
        </div>

    </div>
    <div class="col-sm-4"></div>
</div>

<center>
    <a class="btn btn-default" onclick="mark_all_present()">
        <i class="entypo-check"></i> <?php echo get_phrase('mark_all_present'); ?>
    </a>
    <a class="btn btn-default"  onclick="mark_all_absent()">
        <i class="entypo-cancel"></i> <?php echo get_phrase('mark_all_absent'); ?>
    </a>
</center>
<br>

<div class="row">

    <div class="col-md-2"></div>

    <div class="col-md-8">

        <?php echo form_open(base_url() . 'index.php?admin/staff_attendance_update/' . $staff_type . '/' . $timestamp); ?>

        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo get_phrase('name'); ?></th>
                        <th><?php echo get_phrase('status'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $select_id = 0;
                    $attendance_of_staffs = $this->db->get_where('staff_attendance', array(
                                'staff_type' => $staff_type,
                                //'staff_id'   => $staff_id,
                                'year'       => $running_year,
                                'timestamp'  => $timestamp
                            ))->result_array();


                    foreach ($attendance_of_staffs as $row):
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            
                            <!--check staff type to get staff name -->
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
                            <!--end check -->

                            <td>
                                <select class="form-control" name="status_<?php echo $row['staff_att_id']; ?>" id="status_<?php echo $select_id; ?>">
                                    <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>><?php echo get_phrase('undefined'); ?></option>
                                    <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>><?php echo get_phrase('present'); ?></option>
                                    <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>><?php echo get_phrase('absent'); ?></option>
                                </select>
                            </td>
                        </tr>
                    <?php
                    $select_id++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>

        <center>
            <button type="submit" class="btn btn-success" id="submit_button">
                <i class="entypo-thumbs-up"></i> <?php echo get_phrase('save_changes'); ?>
            </button>
        </center>
        <?php echo form_close(); ?>

    </div>

</div>


<script type="text/javascript">

    var class_selection = "";
    jQuery(document).ready(function($) {
        $('#submit').attr('disabled', 'disabled');
    });
    
    function mark_all_present() {
        var count = <?php echo count($attendance_of_staffs); ?>;

        for(var i = 0; i < count; i++)
            $('#status_' + i).val("1");
    }

    function mark_all_absent() {
        var count = <?php echo count($attendance_of_staffs); ?>;

        for(var i = 0; i < count; i++)
            $('#status_' + i).val("2");
    }

    function check_validation(){
        if(type_selection !== ''){
            $('#submit').removeAttr('disabled')
        }
        else{
            $('#submit').attr('disabled', 'disabled');
        }
    }

    $('#type_selection').change(function(){
        type_selection = $('#type_selection').val();
        check_validation();
    });
</script>
