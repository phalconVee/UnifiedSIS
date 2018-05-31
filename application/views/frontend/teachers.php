<?php
$school_title  = $this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
?>

<div class="page-header">
    <div class="container">
        <h1>Teachers</h1>
        <ul class="breadcrumb">
            <li><a href="<?=base_url();?>">Home</a></li>
            <li class="active">Teachers</li>
        </ul>
    </div>
</div>

<div class="container mt-100 mb-100">

    <div class="row" id="postList">

        <h2 class="heading text-center">Meet our <span class="color2">Teachers</span>
            <span class="sub-heading"><?=$school_title?> encourages an excellent mix of "dedicated and intelligent teachers".</span>
            <span class="icon-divider"></span>
        </h2>

        <?php if(!empty($teachers)) { ?>

        <?php foreach($teachers as $teacher): ?>

            <div class="col-sm-4">
                <div class="teacher-card">

                    <img src="<?php echo base_url();?>image.php/<?php echo $teacher['teacher_id'];?>.jpg?width=200&height=280&cropratio=1:1&image=<?php echo base_url();?>uploads/teacher_image/<?php echo $teacher['teacher_id'];?>.jpg" alt="<?=$teacher['teacher_id'];?>" class="teacher-img img-responsive" />
                    <div class="teacher-detail">
                        <h4 class="heading"><?=$teacher['name']?></h4>
                        <span class="position"><?=$teacher['email']?></span>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        <?php }else { ?>
            <h2> No teachers yet</h2>
        <?php } ?>


        <div class="clearfix"></div>

        <nav>
            <ul class="pagination">
                <?php echo $this->ajax_pagination->create_links(); ?>
            </ul>
        </nav>


    </div>
</div>