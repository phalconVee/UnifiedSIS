<?php 
	
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$running_year       =	$this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($month == 1) $m = 'January';
        else if($month == 2) $m='February';
        else if($month == 3) $m='March';
        else if($month == 4) $m='April';
        else if($month == 5) $m='May';
        else if($month == 6) $m='June';
        else if($month == 7) $m='July';
        else if($month == 8) $m='August';
        else if($month == 9) $m='Sepetember';
        else if($month == 10) $m='October';
        else if($month == 11) $m='November';
        else if($month == 12) $m='December';
?>
<div id="print">
	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<style type="text/css">
		td {
			padding: 5px;
		}
	</style>

	<center>
		<img src="uploads/logo.png" style="max-height : 60px;"><br>
		<h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<?php echo get_phrase('attendance_sheet');?><br>
		<?php echo get_phrase('designation') . ' ' . $staff_type;?><br>
        <?php echo $m . ', ' . $sessional_year; ?>
		
	</center>
        
          <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
                <thead>
                    <tr>
                        <td style="text-align: center;">
    <?php echo get_phrase('students'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
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
                                                            <div style="color: #00a651">P</div>
                                                <?php  } if($status == 2)  { ?>
                                                            <div style="color: #ff3030">A</div>
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
                                                            <div style="color: #00a651">P</div>
                                                <?php  } if($status == 2)  { ?>
                                                            <div style="color: #ff3030">A</div>
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
                                                            <div style="color: #00a651">P</div>
                                                <?php  } if($status == 2)  { ?>
                                                            <div style="color: #ff3030">A</div>
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
                                                            <div style="color: #00a651">P</div>
                                                <?php  } if($status == 2)  { ?>
                                                            <div style="color: #ff3030">A</div>
                                <?php  } $status =0;?>

                                </td>

        <?php } ?>
    <?php endforeach; ?>
<?php endif; ?>


                    </tr>

    <?php ?>

                </tbody>
            </table>
</div>



<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		var elem = $('#print');
		PrintElem(elem);
		Popup(data);

	});

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>