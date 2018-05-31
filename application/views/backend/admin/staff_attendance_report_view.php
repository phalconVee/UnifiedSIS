<hr />

<?php echo form_open(base_url() . 'index.php?admin/attendance_report_selector'); ?>
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

   
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('month'); ?></label>
            <select name="month" class="form-control selectboxit" id="month">
                <?php
                for ($i = 1; $i <= 12; $i++):
                    if ($i == 1)
                        $m = 'january';
                    else if ($i == 2)
                        $m = 'february';
                    else if ($i == 3)
                        $m = 'march';
                    else if ($i == 4)
                        $m = 'april';
                    else if ($i == 5)
                        $m = 'may';
                    else if ($i == 6)
                        $m = 'june';
                    else if ($i == 7)
                        $m = 'july';
                    else if ($i == 8)
                        $m = 'august';
                    else if ($i == 9)
                        $m = 'september';
                    else if ($i == 10)
                        $m = 'october';
                    else if ($i == 11)
                        $m = 'november';
                    else if ($i == 12)
                        $m = 'december';
                    ?>
                    <option value="<?php echo $i; ?>"
                            <?php if ($month == $i) echo 'selected'; ?>  >
                                <?php echo get_phrase($m); ?>
                    </option>
                    <?php
                endfor;
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('sessional_year'); ?></label>
            <select class="form-control selectboxit" name="sessional_year">
                <?php
                $sessional_year_options = explode('-', $running_year); ?>
                <option value="<?php echo $sessional_year_options[0]; ?>" <?php if($sessional_year == $sessional_year_options[0]) echo 'selected'; ?>>
                    <?php echo $sessional_year_options[0]; ?></option>
                <option value="<?php echo $sessional_year_options[1]; ?>" <?php if($sessional_year == $sessional_year_options[1]) echo 'selected'; ?>>
                    <?php echo $sessional_year_options[1]; ?></option>
            </select>
        </div>
    </div>

    <input type="hidden" name="year" value="<?php echo $running_year; ?>">

    <div class="col-md-2" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('show_report'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>


<?php if ($staff_type != '' && $month != '' && $sessional_year != ''): ?>

    <br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" style="text-align: center;">
            <div class="tile-stats tile-gray">
                <div class="icon"><i class="entypo-docs"></i></div>
                <h3 style="color: #696969;">
                    <?php
                                        
                    if ($month == 1)
                        $m = 'January';
                    else if ($month == 2)
                        $m = 'February';
                    else if ($month == 3)
                        $m = 'March';
                    else if ($month == 4)
                        $m = 'April';
                    else if ($month == 5)
                        $m = 'May';
                    else if ($month == 6)
                        $m = 'June';
                    else if ($month == 7)
                        $m = 'July';
                    else if ($month == 8)
                        $m = 'August';
                    else if ($month == 9)
                        $m = 'Sepetember';
                    else if ($month == 10)
                        $m = 'October';
                    else if ($month == 11)
                        $m = 'November';
                    else if ($month == 12)
                        $m = 'December';
                    echo get_phrase('attendance_sheet');
                    ?>
                </h3>

                <h4 style="color: #696969;">
                <?php echo get_phrase('staff_designation'); ?> : <?php echo $staff_type; ?><br>
                <?php echo $m . ', ' . $sessional_year; ?>
                </h4>

            </div>
        </div>
        <div class="col-md-4"></div>
    </div>


    <hr />

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" id="my_table">
                <thead>
                    <tr>
                        <td style="text-align: center;">
    <?php echo get_phrase('name'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                        </td>
    <?php
    $year = explode('-', $running_year);
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $sessional_year);

    for ($i = 1; $i <= $days; $i++) {
        ?>
                    <td style="text-align: center;"><?php echo $i; ?></td>
    <?php } ?>

                    </tr>
                </thead>

                <tbody>
                            <?php
                            $data = array();

                            if($staff_type == 'teacher'):

                            $teachers = $this->db->get_where('teacher')->result_array();

                            foreach ($teachers as $row):
                                ?>
                        <tr>

                            <td style="text-align: center;">
                            <?php echo $row['name']; ?>
                            </td>                            

                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                $timestamp = strtotime($i . '-' . $month . '-' . $sessional_year);
                                $this->db->group_by('timestamp');
                                $attendance = $this->db->get_where('staff_attendance', array('staff_type' => $staff_type, 'year' => $running_year, 'timestamp' => $timestamp, 'staff_id' => $row['teacher_id']))->result_array();


                                foreach ($attendance as $row1):
                                    $month_dummy = date('d', $row1['timestamp']);

                                    if ($i == $month_dummy)
                                    $status = $row1['status'];


                                endforeach;
                                ?>
                                <td style="text-align: center;">
                                <?php if ($status == 1) { ?>
                                                            <i class="entypo-record" style="color: #00a651;"></i>
                                                <?php  } if($status == 2)  { ?>
                                                            <i class="entypo-record" style="color: #ee4749;"></i>
                                <?php  } $status =0;?>

                                </td>

        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>


                        <?php
                            
                            if($staff_type == 'accountant'):

                            $accountant = $this->db->get_where('accountant')->result_array();

                            foreach ($accountant as $row):
                                ?>
                        <tr>

                            <td style="text-align: center;">
                            <?php echo $row['name']; ?>
                            </td>                            

                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                $timestamp = strtotime($i . '-' . $month . '-' . $sessional_year);
                                $this->db->group_by('timestamp');
                                $attendance = $this->db->get_where('staff_attendance', array('staff_type' => $staff_type, 'year' => $running_year, 'timestamp' => $timestamp, 'staff_id' => $row['accountant_id']))->result_array();


                                foreach ($attendance as $row1):
                                    $month_dummy = date('d', $row1['timestamp']);

                                    if ($i == $month_dummy)
                                    $status = $row1['status'];


                                endforeach;
                                ?>
                                <td style="text-align: center;">
                                <?php if ($status == 1) { ?>
                                                            <i class="entypo-record" style="color: #00a651;"></i>
                                                <?php  } if($status == 2)  { ?>
                                                            <i class="entypo-record" style="color: #ee4749;"></i>
                                <?php  } $status =0;?>

                                </td>

        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>

            
                        <?php
                            
                            if($staff_type == 'librarian'):

                            $librarian = $this->db->get_where('librarian')->result_array();

                            foreach ($librarian as $row):
                                ?>
                        <tr>

                            <td style="text-align: center;">
                            <?php echo $row['name']; ?>
                            </td>                            

                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                $timestamp = strtotime($i . '-' . $month . '-' . $sessional_year);
                                $this->db->group_by('timestamp');
                                $attendance = $this->db->get_where('staff_attendance', array('staff_type' => $staff_type, 'year' => $running_year, 'timestamp' => $timestamp, 'staff_id' => $row['librarian_id']))->result_array();


                                foreach ($attendance as $row1):
                                    $month_dummy = date('d', $row1['timestamp']);

                                    if ($i == $month_dummy)
                                    $status = $row1['status'];


                                endforeach;
                                ?>
                                <td style="text-align: center;">
                                <?php if ($status == 1) { ?>
                                                            <i class="entypo-record" style="color: #00a651;"></i>
                                                <?php  } if($status == 2)  { ?>
                                                            <i class="entypo-record" style="color: #ee4749;"></i>
                                <?php  } $status =0;?>

                                </td>

        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>

                
                        <?php
                            
                            if($staff_type == 'employee'):

                            $employee = $this->db->get_where('employee')->result_array();

                            foreach ($employee as $row):
                                ?>
                        <tr>

                            <td style="text-align: center;">
                            <?php echo $row['name']; ?>
                            </td>                            

                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                $timestamp = strtotime($i . '-' . $month . '-' . $sessional_year);
                                $this->db->group_by('timestamp');
                                $attendance = $this->db->get_where('staff_attendance', array('staff_type' => $staff_type, 'year' => $running_year, 'timestamp' => $timestamp, 'staff_id' => $row['emp_id']))->result_array();


                                foreach ($attendance as $row1):
                                    $month_dummy = date('d', $row1['timestamp']);

                                    if ($i == $month_dummy)
                                    $status = $row1['status'];


                                endforeach;
                                ?>
                                <td style="text-align: center;">
                                <?php if ($status == 1) { ?>
                                                            <i class="entypo-record" style="color: #00a651;"></i>
                                                <?php  } if($status == 2)  { ?>
                                                            <i class="entypo-record" style="color: #ee4749;"></i>
                                <?php  } $status =0;?>

                                </td>

        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>


                    </tr>

    <?php ?>

                </tbody>
            </table>

            <center>
                <a href="<?php echo base_url(); ?>index.php?admin/staff_attendance_report_print_view/<?php echo $staff_type; ?>/<?php echo $month; ?>/<?php echo $sessional_year; ?>"
                   class="btn btn-primary" target="_blank">
                <?php echo get_phrase('print_staff_attendance_sheet'); ?>
                </a>
            </center>

        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">

    // ajax form plugin calls at each modal loading,
    $(document).ready(function() {

        // SelectBoxIt Dropdown replacement
        if($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function(i, el)
            {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }
    });

</script>


