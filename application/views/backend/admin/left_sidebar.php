<div class="col-md-2">
    <a href="<?php base_url();?>index.php?admin/noticeboard"
       class="<?php if ($page_name == 'noticeboard'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('noticeboard');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/frontend_pages/events"
       class="<?php if ($page_name == 'events'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('events');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/teacher"
       class="<?php if ($page_name == 'teacher'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('teachers');?>
    </a>
    <!--<a href="<?php base_url();?>index.php?admin/frontend_pages/gallery"
       class="<?php if ($page_name == 'gallery'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('gallery');?>
    </a>-->
    <a href="<?php base_url();?>index.php?admin/frontend_pages/about_us"
       class="<?php if ($page_name == 'about_us'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('about_us');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/frontend_pages/terms_conditions"
       class="<?php if ($page_name == 'terms_conditions'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('terms_&_conditions');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/frontend_pages/privacy_policy"
       class="<?php if ($page_name == 'privacy_policy'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?>">
        <?php echo get_phrase('privacy_policy');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/frontend_pages/homepage_slider"
       class="<?php if ($page_name == 'homepage_slider'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?> ">
        <?php echo get_phrase('homepage_slider');?>
    </a>
    <a href="<?php base_url();?>index.php?admin/frontend_pages/general"
       class="<?php if ($page_name == 'frontend_pages'){ echo 'btn btn-primary btn-block';} else{ echo 'btn btn-default btn-block'; } ?> ">
        <?php echo get_phrase('frontend_pages');?>
    </a>
</div>