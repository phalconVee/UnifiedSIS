<?php
    $school_title    =	$this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
    $address         =	$this->db->get_where('settings_frontend' , array('type'=>'address'))->row()->description;
    $phone           =	$this->db->get_where('settings_frontend' , array('type'=>'phone'))->row()->description;
    $email           =	$this->db->get_where('settings_frontend' , array('type'=>'school_email'))->row()->description;
    $facebook        =	$this->db->get_where('settings_frontend' , array('type'=>'facebook_profile'))->row()->description;
    $twitter         =	$this->db->get_where('settings_frontend' , array('type'=>'twitter_profile'))->row()->description;
    $linkedin        =	$this->db->get_where('settings_frontend' , array('type'=>'linkedin_profile'))->row()->description;
    $instagram       =	$this->db->get_where('settings_frontend' , array('type'=>'google_profile'))->row()->description;
?>

<footer class="footer">
    <div class="footer-pri">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-2 footer-widget">
                    &nbsp;
                </div>

                <div class="col-sm-4 footer-widget">
                    <h5 class="heading inverse">Contact  <span class="color2">Us</span></h5>
                    <address>
                        <strong><?=$school_title?></strong>
                        <span><?=$address?>, Nigeria</span>
                    </address>
                    <a href="tel:<?=$phone?>" class="phone"><i class="fa fa-phone fa-fw"></i> <?=$phone?></a>
                    <a href="mailto:<?=$email?>" class="email"><i class="fa fa-envelope fa-fw"></i> <?=$email?></a>
                </div>


                <div class="col-sm-4 footer-widget">
                    <h5 class="heading inverse">Quick <span class="color2">Links</span></h5>
                    <ul class="quick-links">
                        <li><a href="<?=base_url('index.php?pages/privacy');?>">Privacy Policy</a></li>
                        <li><a href="<?=base_url('index.php?pages/terms-conditions');?>">Terms &amp; Conditions</a></li>
                        <li><a href="<?=base_url('index.php?pages/contact-us');?>">Contact Us</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>

                <div class="col-sm-2 footer-widget">
                    &nbsp;
                </div>

            </div>
        </div>
    </div>


    <div class="footer-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <span class="copyright">&copy;Powered by <a href="http://intellisense.com.ng">BIGSchool</a> <?= date('Y');?></span>
                </div>
                <div class="col-sm-6 text-center">
                    <ul class="social">          <!-- Social Media Links -->
                        <li><a href="<?=$facebook?>"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?=$twitter?>"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?=$instagram?>"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="<?=$linkedin?>"><i class="fa fa-linkedin"></i></a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>



<div id="back"><i class="fa fa-angle-up"></i></div>

<script src="<?=base_url('assets/theme/js/jquery.min.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/bootstrap.min.js');?>" type="text/javascript"></script>

<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/jquery.themepunch.tools.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/jquery.themepunch.revolution.min.js');?>"></script>

<!-- Include only when working on Local system. Not required on server -->
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/extensions/revolution.extension.parallax.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/extensions/revolution.extension.video.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/extensions/revolution.extension.slideanims.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/extensions/revolution.extension.navigation.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/theme/slider-revolution/js/extensions/revolution.extension.layeranimation.min.js');?>"></script>

<script src="<?=base_url('assets/theme/js/jquery.countdown.min.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/owl.carousel.min.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/jquery.countTo.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/jquery.appear.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/jquery.prettyPhoto.js');?>" type=text/javascript></script>

<script src="<?=base_url('assets/theme/js/parallax.js');?>" type="text/javascript"></script>

<script src="<?=base_url('assets/theme/js/main.js');?>" type=text/javascript></script>

<script src="<?=base_url('assets/theme/js/color-switch.js');?>" type="text/javascript"></script>
