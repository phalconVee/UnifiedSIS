<?php $student_id = $this->session->userdata('login_user_id'); ?>


<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('result_checker');?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?student/result_checker/'.$student_id.'/check_result/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                <div class="form-group">

                    <?php
                        $credential = array('student_id' => $student_id);
                        $query = $this->db->get_where('cards', $credential);
                        $pin = '';
                        if($query->num_rows() == 1) {
                            $row = $query->row();
                            $pin = $row->pin;
                        }
                    ?>

                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('pin');?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="pin" id="pin" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$pin;?>" autofocus required>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('check_result');?></button>
                    </div>
                </div>


                <?php echo form_close();?>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <blockquote class="blockquote-blue">
            <p>
                <strong>Check Results</strong>
            </p>
            <p>
                Input your unique pin to view results for the current academic session. The pin is a unique seven (7) alphanumeric character given to you by the school.
            </p>
        </blockquote>


    </div>

</div>


<div class="row">
	<div class="col-md-8">

        <div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-line-chart"></i>
                            <?php echo get_phrase('daily_attendance_overview');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                       <canvas id="mycanvas" width="600" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    	
    </div>
    
	<div class="col-md-4">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Latest News Feed</div>
                </div>

                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>S/n</th>
                        <th>Title</th>
                        <th>Date</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php $i= 0; foreach($notices as $notice): ?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$notice['notice_title']?></td>
                        <td><?=date('d M, Y', $notice['create_timestamp']);?></td>
                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

            </div>

            <div>
                <center><a href="<?=base_url('index.php?student/noticeboard')?>" class="btn btn-primary btn-sm">View More</a></center>
            </div>

            <br>

        </div>

        <div class="row">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Birthday Today</div>
                </div>

                    <div class="table-responsive">
                        <table class="table table-xlg text-nowrap">
                            <tbody>
                            <tr>
                                <td class="col-md-4">
                                    <div class="media-left media-middle">
                                        <a href="" style="color: pink;"><i class="fa fa-birthday-cake" style="font-size:48px; "></i></a>
                                    </div>

                                    <div class="media-left ">
                                        <h4>
                                            <b><center>0</b></center><small class="display-block no-margin">Students have birthday today</small>
                                        </h4>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
        </div>

    </div>

	
</div>

<div class="row">
    <div class="col-md-8">

        <div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){

        var day = <?php echo $label; ?>;


        var data = {
            labels: day,
            //labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: "Attendance Status:" + <?php echo $result1;?>,
                    fillColor: dynamicColors(),
                    strokeColor: dynamicColors(),
                    pointColor: dynamicColors(),
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: dynamicColors(),
                    data: <?php echo $result1; ?>
                }

            ]
        };

        var ctx = document.getElementById("mycanvas").getContext("2d");
        new Chart(ctx).Bar(data, {
            responsive: true, maintainAspectRatio: true, scaleBeginAtZero: false

        });

        //document.getElementById("demoLegend").innerHTML = chart.generateLegend();
    });

    function dynamicColors() {

        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";

    }
    
</script>

    <script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 380,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});
  </script>

  
