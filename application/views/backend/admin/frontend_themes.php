<hr />

<div class="row">

<?php
$skin = $this->db->get_where('settings_frontend' , array(
    'type' => 'skin_colour'
))->row()->description;
?>

<div class="col-md-12">

<div class="panel panel-primary" >

    <div class="panel-heading">
        <div class="panel-title">
            <?php echo get_phrase('frontend_theme_settings');?>
        </div>
    </div>

    <div class="panel-body">

        <div class="gallery-env">

            <div class="col-sm-4">
                <article class="album">
                    <header>
                        <a href="#" id="default">
                            <img src="assets/theme/images/skins/yellow.png"
                                <?php if ($skin == 'yellow') echo 'style="background-color: black; opacity: 0.3;"';?> />
                        </a>
                        <a href="#" class="album-options" id="yellow">
                            <i class="entypo-check"></i>
                            <?php echo get_phrase('default');?>
                        </a>
                    </header>
                </article>
            </div>

            <div class="col-sm-4">
                <article class="album">
                    <header>
                        <a href="#" id="blue">
                            <img src="assets/theme/images/skins/blue.png"
                                <?php if ($skin == 'blue') echo 'style="background-color: black; opacity: 0.3;"';?> />
                        </a>
                        <a href="#" class="album-options" id="blue">
                            <i class="entypo-check"></i>
                            <?php echo get_phrase('select_theme');?>
                        </a>
                    </header>
                </article>
            </div>
            <div class="col-sm-4">
                <article class="album">
                    <header>
                        <a href="#" id="green">
                            <img src="assets/theme/images/skins/green.png"
                                <?php if ($skin == 'green') echo 'style="background-color: black; opacity: 0.3;"';?> />
                        </a>
                        <a href="#" class="album-options" id="green">
                            <i class="entypo-check"></i>
                            <?php echo get_phrase('select_theme');?>
                        </a>
                    </header>
                </article>
            </div>
            <div class="col-sm-4">
                <article class="album">
                    <header>
                        <a href="#" id="red">
                            <img src="assets/theme/images/skins/red.png"
                                <?php if ($skin == 'red') echo 'style="background-color: black; opacity: 0.3;"';?> />
                        </a>
                        <a href="#" class="album-options" id="red">
                            <i class="entypo-check"></i>
                            <?php echo get_phrase('select_theme');?>
                        </a>
                    </header>
                </article>
            </div>


        </div>

        <center>
            <div class="label label-primary" style="font-size: 12px;">
                <i class="entypo-check"></i> <?php echo get_phrase('select_a_theme_to_make_changes');?>
            </div>
        </center>
    </div>

</div>


</div>

</div>

<script type="text/javascript">
    $(".gallery-env").on('click', 'a', function () {
        skin = this.id;
        $.ajax({
            url: '<?php echo base_url();?>index.php?admin/frontend_themes/change_theme_skin/'+ skin,
            success: window.location = '<?php echo base_url();?>index.php?admin/frontend_themes/'
        });
    });
</script>
