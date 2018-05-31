<?php if(!empty($events)) { ?>

    <?php foreach($events as $event): ?>

        <div class="col-sm-6" id="postList">
            <div class="event-card">
                <div class="event-on">
                    <span class="date"><?php echo date('d', $event['date']); ?></span>
                    <span class="month"><?php echo date('M', $event['date']); ?></span>
                </div>

                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>

                <div class="event-detail mt-80">
                    <h4 class="heading"><?=$event['title']?></h4>

                </div>
                <ul class="timer" data-date="<?php echo date('Y/m/d H:i:s', $event['date']); ?>">
                    <li><span class="days">0</span>days</li>
                    <li><span class="hours">0</span>hrs</li>
                    <li><span class="minutes">00</span>min</li>
                    <li><span class="seconds">00</span>sec</li>
                </ul>
            </div>
        </div>

    <?php endforeach; ?>

<?php }else { ?>
    <h2> No available event(s) yet</h2>
<?php } ?>

<div class="clearfix"></div>

<nav>
    <ul class="pagination">
        <?php echo $this->ajax_pagination->create_links(); ?>
    </ul>
</nav>
