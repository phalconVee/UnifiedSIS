<div class="page-header">
    <div class="container">
        <h1>Noticeboard</h1>
        <ul class="breadcrumb">
            <li><a href="<?=base_url();?>">Home</a></li>
            <li class="active">Noticeboard</li>
        </ul>
    </div>
</div>

<div class="container mb-20">
    <div class="row">
        <div class="col-sm-12" id="postList">

            <?php if(!empty($notices)) { ?>

            <?php foreach($notices as $notice): ?>

                <div class="blog-card" >
                    <div class="posted-on">
                        <span class="date"><?php echo date('d', $notice['create_timestamp']); ?></span>
                        <span class="month"><?php echo date('M', $notice['create_timestamp']); ?></span>
                    </div>

                    <div class="blog-body mt-100">
                        <a href="#" class="blog-title"><h3><?=$notice['notice_title']?></h3></a>
                        <p><?=$notice['notice']?>
                        </p>

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

        </div>

        <!--<div class="col-sm-4">
            <aside class="widget twitter-widget">
                <h5 class="heading">Twitter Feed</h5>
                <ul class="tweet-list">
                    <li>We've done it again. Educomp wins <a href="#">#SirEdward</a> award yet again! Kudos to all Educomp family!</li>
                </ul>
            </aside>


            <aside class="widget download-widget text-center">
                <div class="download-info">
                    <p class="inverse font24">Join the best people in industry.</p><br/>
                    <a href="admission-process.html" class="btn btn-default">Apply Now</a>
                </div>
            </aside>

        </div>-->

    </div>

    <div class="loading" style="display: none;">
        <div class="content"><img src="<?php echo base_url().'assets/theme/images/gif/3.gif'; ?>"/>
        </div>
    </div>

</div>