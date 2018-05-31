<?php
$title_0	=	$this->db->get_where('settings_frontend' , array('type'=>'slider_title_0'))->row()->description;
$title_1	=	$this->db->get_where('settings_frontend' , array('type'=>'slider_title_1'))->row()->description;
$title_2	=	$this->db->get_where('settings_frontend' , array('type'=>'slider_title_2'))->row()->description;
$desc_0 	=	$this->db->get_where('settings_frontend' , array('type'=>'slider_description_0'))->row()->description;
$desc_1	    =	$this->db->get_where('settings_frontend' , array('type'=>'slider_description_1'))->row()->description;
$desc_2 	=	$this->db->get_where('settings_frontend' , array('type'=>'slider_description_2'))->row()->description;
?>

<!-- Slider Revolution -->
<div class="rev_slider_wrapper fullwidthbanner-container">
<div id="slider" class="rev_slider fullwidthbanner" data-version="5.0.7">
<ul>
<!-- Slide 1 -->
<li data-index="rs-129"
    data-transition="parallaxvertical"
    data-slotamount="default"
    data-easein="default"
    data-easeout="default"
    data-masterspeed="default"
    data-thumb=""
    data-rotate="0"
    data-fstransition="fade"
    data-fsmasterspeed="1500"
    data-fsslotamount="7"
    data-saveperformance="off"
    data-title="<?=$title_0?>"
    data-description="<?=$desc_0?>">

    <!-- MAIN IMAGE -->
    <img src="<?=base_url();?>uploads/frontend/slider/0.jpg" data-lazyload="<?=base_url();?>uploads/frontend/slider/0.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
    <!-- Overlay-->
    <div class="tp-caption tp-shape tp-shapewrapper   tp-resizeme rs-parallaxlevel-0"
         id="slide-1-overlay"
         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
         data-width="full"
         data-height="full"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="opacity:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="opacity:0;s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
         data-start="1000"
         data-basealign="slide"
         data-responsive_offset="on"
         style="z-index: 5;background-color:rgba(0, 0, 0, 0.3);border-color:rgba(0, 0, 0, 1.00);">
    </div>

    <!-- Small Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0 color2"
         id="slide-1-small-text"
         data-x="['right','right','right','right']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-120','-120','-120','-120']"
         data-width="none"
         data-fontsize="['22', '22', '22', '16']"
         data-height="28"
         data-whitespace="nowrap"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 6; white-space: nowrap; font-weight:bold; font-family: 'Libre Baskerville', serif;"><?=$title_0?>
    </div>

    <!-- Main Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0"
         id="slide-1-main-text"
         data-x="['right','right','right','right']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-50','-50','-50','-50']"
         data-fontsize="['46','46','46','32']"
         data-lineheight="['55','55','55','35']"
         data-color="['#fff']"
         data-width="['600','600','600','420']"
         data-height="none"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 7; min-width: 600px; max-width: 600px; white-space: normal; text-shadow:0px 2px 2px #000; text-transform:capitalize; font-weight:600; text-align:right; font-family: 'Montserrat', sans-serif;"><?=$desc_0?>
    </div>


</li>

<!-- Slide 2 -->
<li data-index="rs-2"
    data-transition="parallaxvertical"
    data-slotamount="default"
    data-easein="default"
    data-easeout="default"
    data-masterspeed="default"
    data-thumb=""
    data-rotate="0"
    data-fstransition="fade"
    data-fsmasterspeed="1500"
    data-fsslotamount="7"
    data-saveperformance="off"
    ddata-title="<?=$title_1?>"
    data-description="<?=$desc_1?>">

    <!-- MAIN IMAGE -->
    <img src="<?=base_url();?>uploads/frontend/slider/1.jpg" data-lazyload="<?=base_url();?>uploads/frontend/slider/1.jpg" alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
    <!-- Overlay -->
    <div class="tp-caption tp-shape tp-shapewrapper   tp-resizeme rs-parallaxlevel-0"
         id="slide-2-overlay"
         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
         data-width="full"
         data-height="full"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="opacity:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="opacity:0;s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
         data-start="1000"
         data-basealign="slide"
         data-responsive_offset="on"
         style="z-index: 9;background-color:rgba(0, 0, 0, 0.3);border-color:rgba(0, 0, 0, 1.00);">
    </div>

    <!-- Small Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0 color2"
         id="layer-2-small-text"
         data-x="['left','left','left','left']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-120','-120','-120','-120']"
         data-width="none"
         data-fontsize="['22', '22', '22', '16']"
         data-height="28"
         data-whitespace="nowrap"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 10; white-space: nowrap; font-weight:bold; font-family: 'Libre Baskerville', serif;"><?=$title_1?>
    </div>

    <!-- Main Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0"
         id="slide-2-main-text"
         data-x="['left','left','left','left']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-50','-50','-50','-50']"
         data-fontsize="['46','46','46','32']"
         data-lineheight="['55','55','55','35']"
         data-color="['#fff']"
         data-width="['600','600','600','420']"
         data-height="none"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 11; min-width: 600px; max-width: 600px; white-space: normal; text-shadow:0px 2px 2px #000; text-transform:capitalize; font-weight:600; text-align:left; font-family: 'Montserrat', sans-serif;"><?=$desc_1?>
    </div>
</li>

<!-- Slide 3 -->
<li data-index="rs-2"
    data-transition="parallaxvertical"
    data-slotamount="default"
    data-easein="default"
    data-easeout="default"
    data-masterspeed="default"
    data-thumb=""
    data-rotate="0"
    data-fstransition="fade"
    data-fsmasterspeed="1500"
    data-fsslotamount="7"
    data-saveperformance="off"
    ddata-title="<?=$title_2?>"
    data-description="<?=$desc_2?>">

    <!-- MAIN IMAGE -->
    <img src="<?=base_url();?>uploads/frontend/slider/2.jpg" data-lazyload="<?=base_url();?>uploads/frontend/slider/2.jpg" alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
    <!-- Overlay -->
    <div class="tp-caption tp-shape tp-shapewrapper   tp-resizeme rs-parallaxlevel-0"
         id="slide-2-overlay"
         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
         data-width="full"
         data-height="full"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="opacity:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="opacity:0;s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
         data-start="1000"
         data-basealign="slide"
         data-responsive_offset="on"
         style="z-index: 9;background-color:rgba(0, 0, 0, 0.3);border-color:rgba(0, 0, 0, 1.00);">
    </div>

    <!-- Small Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0 color2"
         id="layer-2-small-text"
         data-x="['left','left','left','left']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-120','-120','-120','-120']"
         data-width="none"
         data-fontsize="['22', '22', '22', '16']"
         data-height="28"
         data-whitespace="nowrap"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 10; white-space: nowrap; font-weight:bold; font-family: 'Libre Baskerville', serif;"><?=$title_2?>
    </div>

    <!-- Main Text -->
    <div class="tp-caption tp-resizeme rs-parallaxlevel-0"
         id="slide-2-main-text"
         data-x="['left','left','left','left']" data-hoffset="['50','50','50','30']"
         data-y="['middle','middle','middle','middle']" data-voffset="['-50','-50','-50','-50']"
         data-fontsize="['46','46','46','32']"
         data-lineheight="['55','55','55','35']"
         data-color="['#fff']"
         data-width="['600','600','600','420']"
         data-height="none"
         data-whitespace="normal"
         data-transform_idle="o:1;"
         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
         data-start="1000"
         data-splitin="none"
         data-splitout="none"
         data-responsive_offset="on"
         style="z-index: 11; min-width: 600px; max-width: 600px; white-space: normal; text-shadow:0px 2px 2px #000; text-transform:capitalize; font-weight:600; text-align:left; font-family: 'Montserrat', sans-serif;"><?=$desc_2?>
    </div>
    
</li>


</ul>
</div>
</div>
<!-- Revolution Slider Ends -->

<div class="bgcolor2 text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <button class="btn-announce"><i class="fa fa-bullhorn"></i></button>
                <div class="announcement">
                    <div class="announcement-text">

                        <?php foreach($noticeBoard as $notice): ?>
                        <span> <?=$notice['notice']; ?></span>
                        <!--<span>Exams postponed by 10 days due to Annual Day celebrations</span>
                        <span>Late Fee of 10% to be charged from defaulters</span>-->
                        <?php endforeach; ?>

                    </div>
                    <div class="owl-nav">
                        <span class="owl-left"><i class="fa fa-angle-left"></i></span>
                        <span class="owl-right"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
