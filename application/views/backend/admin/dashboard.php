<!-- Resources -->
<style>
    #chartdiv2, #chartdiv {
        width       : 100%;
        height      : 300px;
        font-size   : 11px;
    }
    .style2 {font-size: 24px}
</style>

<hr />

<div class="row">
    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-red">

            <div class="icon"><i class="fa fa-group"></i></div>
            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('student');?>"
                 data-postfix="" data-duration="1500" data-delay="0">0</div>

            <h3><?php echo get_phrase('student');?></h3>
            <p>Total students</p>

        </div>

    </div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-green">
            <div class="icon"><i class="entypo-users"></i></div>
            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('teacher');?>"
                 data-postfix="" data-duration="800" data-delay="0">0</div>

            <h3><?php echo get_phrase('teacher');?></h3>
            <p>Total teachers</p>
        </div>

    </div>

    <div class="clear visible-xs"></div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-aqua">
            <div class="icon"><i class="entypo-user"></i></div>
            <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('parent');?>"
                 data-postfix="" data-duration="500" data-delay="0">0</div>

            <h3><?php echo get_phrase('parent');?></h3>
            <p>Total parents</p>
        </div>

    </div>

    <div class="col-sm-3 col-xs-6">

        <div class="tile-stats tile-blue">
            <div class="icon"><i class="entypo-chart-bar"></i></div>
            <?php
            $check	=	array(	'timestamp' => strtotime(date('Y-m-d')) , 'status' => '1' );
            $query = $this->db->get_where('attendance' , $check);
            $present_today		=	$query->num_rows();
            ?>
            <div class="num" data-start="0" data-end="<?php echo $present_today;?>"
                 data-postfix="" data-duration="500" data-delay="0">0</div>

            <h3><?php echo get_phrase('attendance');?></h3>
            <p>Total present student today</p>
        </div>

    </div>
</div>

<br />

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- ATTENDANCE-->
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-chart"></i>
                            <?php echo get_phrase('daily_attendance_overview_(_students_&_staff)');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">

                        <div id="demoLegend" class="chart-legend"> </div>
                        <canvas id="mycanvas" width="600" height="200"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<br />

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">
              <div class="panel panel-primary " data-collapsed="0">
                  <div class="panel-heading">
                      <div class="panel-title">
                          <i class="fa fa-calendar"></i>
                          <?php echo get_phrase('stats');?>
                      </div>
                  </div>

                  <div class="panel-body" style="padding:0px;">
                      <div id="chartdiv"></div>
                  </div>

              </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
      <div class="row">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <div class="panel-title"><i class="fa fa-newspaper-o"></i> Latest News Feed</div>
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
                  <center><a href="<?=base_url('index.php?admin/noticeboard')?>" class="btn btn-primary btn-sm">View More</a></center>
              </div>

              <br>

        </div>

          <div class="row">

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <div class="panel-title"><i class="fa fa-birthday-cake"></i> Birthday Today</div>
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

      </div><!--here-->

</div>

<br />

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('events_schedule');?>
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

<script src="assets/vendors/echarts/dist/echarts.min.js"></script>

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
					height: 350,
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


<script type="text/javascript">
    $(document).ready(function(){

        var day = <?php echo $label; ?>;

        var data = {
            labels: day,
            //labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: "Student Attendance Status",
                    fillColor: dynamicColors(),
                    strokeColor: dynamicColors(),
                    pointColor: dynamicColors(),
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: dynamicColors(),
                    data: <?php echo $result1; ?>
                },
                {
                    label: "Staff Attendance Status",
                    fillColor: dynamicColors2(),
                    strokeColor: dynamicColors2(),
                    pointColor: dynamicColors2(),
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: dynamicColors2(),
                    data: <?php echo $result2; ?>
                }

            ]
        };

        var ctx = document.getElementById("mycanvas").getContext("2d");
        var mychart = new Chart(ctx).Bar(data, {
            responsive: true, maintainAspectRatio: true

        });

        document.getElementById('demoLegend').innerHTML = mychart.generateLegend();


        //document.getElementById("demoLegend").innerHTML = chart.generateLegend();
    });

    function dynamicColors() {

        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    }

    function dynamicColors2() {

        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";

    }

</script>

<!--pie chart-->
<script>

    $(document).ready(function(){


        console.log('init_echarts');
        var theme = {
            color: [
                '#3498DB', '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
            ],
            textStyle: {
                fontFamily: 'Arial, Verdana, sans-serif'
            }
        };

        if ($('#chartdiv').length) {

            var echartPie = echarts.init(document.getElementById('chartdiv'), theme);
            echartPie.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                    data: ['<?php echo get_phrase('section'); ?>', '<?php echo get_phrase('transportations'); ?>', '<?php echo get_phrase('expenses'); ?>']
                },
                toolbox: {
                    show: true,
                    feature: {
                        magicType: {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '45%',
                                    width: '80%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },
                        restore: {
                            show: true,
                            title: "Restore"
                        },
                        saveAsImage: {
                            show: true,
                            title: "Save Image"
                        }
                    }
                },
                calculable: true,
                series: [{
                        name: 'Current Status',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '48%'],
                        data: [{
                                value: <?php echo $this->db->count_all('section'); ?>,
                                name: '<?php echo get_phrase('section'); ?>'
                            }, {
                                value: <?php echo $this->db->count_all('transport'); ?>,
                                name: '<?php echo get_phrase('transportation'); ?>'
                            }, {
                                value: <?php echo $this->db->count_all('expense_category'); ?>,
                                name: '<?php echo get_phrase('expenses'); ?>'
                            }]
                    }]
            });
            var dataStyle = {
                normal: {
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                }
            };
            var placeHolderStyle = {
                normal: {
                    color: 'rgba(0,0,0,0)',
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                },
                emphasis: {
                    color: 'rgba(0,0,0,0)'
                }
            };
        }

    });
</script>
