<div class="mb-100">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mt-100">
                <h3 class="heading"><span class="color2"><?=$homepage_note_title?></span></h3>

                <?=$homepage_note_description?>

                <div class="clearfix"></div>
                <br/>
            </div>


            <div class="col-sm-4 mt-80">
                <div class="icon-box-4">
                    <div class="icon-box-icon">
                        <i class="fa fa-rocket" aria-hidden="true"></i>
                    </div>
                    <div class="icon-box-content">
                        <h5 class="heading">Work Together</h5>
                        <span>We believe in team work; working towards a common goal.</span>
                    </div>
                </div>
                <div class="icon-box-4">
                    <div class="icon-box-icon">
                        <i class="fa fa-diamond" aria-hidden="true"></i>
                    </div>
                    <div class="icon-box-content">
                        <h5 class="heading">Our Leadership</h5>
                        <span>We believe in stron and passionate leadership across board..</span>
                    </div>
                </div>
                <div class="icon-box-4">
                    <div class="icon-box-icon">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                    </div>
                    <div class="icon-box-content">
                        <h5 class="heading">Better World</h5>
                        <span>Building a better world through the inspiration of our students.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="bgcolor3 pt-20 pb-40 mb-100">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="facts">

                        <div class="fact col-sm-4">
                                <span class="head">
                                    <span class="count" data-from="0" data-to="<?=$total_subjects?>" data-speed="3000"><?=$total_subjects?></span> Subjects
                                </span>
                            <span class="foot">A wide range of subjects taught in details following standard curriculum!</span>
                        </div>

                        <div class="fact col-sm-4">
                                <span class="head">
                                    <span class="count" data-from="0" data-to="<?=$total_students?>" data-speed="3000"><?=$total_students?></span> Students
                                </span>
                            <span class="foot">Average number of students per class. Offering world class education.</span>
                        </div>

                        <div class="fact col-sm-4">
                                <span class="head">
                                    <span class="count" data-from="0" data-to="<?=$total_teachers?>" data-speed="3000">15</span> Teachers
                                </span>
                            <span class="foot">We have an excellent mix of <i>"dedicated and intelligent teachers"</i>. </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="clearfix"></div>

<div class="event pt-100 pb-100" data-parallax="scroll" data-image-src="<?=base_url();?>assets/theme/images/event-background.jpg">
    <div class="container">
        <h2 class="heading text-center">Upcoming <span class="color2">Event</span>
            <span class="sub-heading">Countdown timer for upcoming events and a detailed page for events. Allow people to participate and make it a big hit!</span>
            <span class="icon-divider"></span>
        </h2>

        <?php foreach($events as $event): ?>

            <div class="row">
                <div class="col-sm-5">
                    <div class="next-event">
                        <span class="event-date"><?php echo date('d', $event['date']); ?></span> <?php echo date('M', $event['date']);?>, <?php echo date('Y', $event['date']);?>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="event-details mt-60">
                        <p><?=$event['title']?></p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>



        <div class="clearfix"></div>

        <div class="row text-center mt-60">
            <a href="<?=base_url('events');?>" class="btn btn-primary">View All Events</a>
        </div>
    </div>
</div>
    