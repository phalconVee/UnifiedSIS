<?php if(!empty($notices)) { ?>

    <?php foreach($notices as $notice): ?>

        <div class="blog-card" id="postList">
            <div class="posted-on">
                <span class="date"><?php echo date('d', $notice['create_timestamp']); ?></span>
                <span class="month"><?php echo date('M', $notice['create_timestamp']); ?></span>
            </div>

            <div class="blog-body mt-100">
                <a href="#" class="blog-title"><h3><?=$notice['notice_title']?></h3></a>
                <p><?=$notice['notice']?></p>
            </div>
        </div>

    <?php endforeach; ?>

<?php }else { ?>
    <h2> No available notice(s) yet</h2>
<?php } ?>

<div class="clearfix"></div>

<nav>
    <ul class="pagination">
        <?php echo $this->ajax_pagination->create_links(); ?>
    </ul>
</nav>