<?php if(!empty($teachers)) { ?>

    <?php foreach($teachers as $teacher): ?>

        <div class="col-sm-4" id="postList">
            <div class="teacher-card">

                <img src="<?=base_url();?>uploads/teacher_image/<?=$teacher['teacher_id']?>.jpg" class="teacher-img img-responsive" alt="" width="450" height="623">

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
