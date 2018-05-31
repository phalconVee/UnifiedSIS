<!DOCTYPE html><!-- 

<html lang="en" >
	<!-- begin::Head -->
<head>
    <?php
    $system_name	=	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $system_title	=	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
    ?>
    <meta charset="utf-8" />

    <title><?php echo get_phrase('login');?> | <?php echo $system_title;?></title>

    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <!--begin::Base Styles -->
    <link href="assets/metronic/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/metronic/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Base Styles -->

    <link rel="shortcut icon" href="assets/images/favicon-4.png">

    <style>
        /* ---- particles.js container ---- */
        #particles-js {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: 50% 50%;
            position: fixed;
            /*top: 0px;*/
            z-index:1;
        }

    </style>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
    var siteUrl = '<?php echo base_url();?>';
</script>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url(assets/metronic/app/media/img/bg/bg-2.jpg);">

        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container" style="position:relative;z-index: 9999;">

                <div class="m-login__logo">
                    <a href="<?php echo base_url();?>" class="logo">
                        <img src="uploads/logo.png" height="60" alt="" />
                    </a>
                </div>

                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            <?php echo $system_name;?>
                        </h3>
                    </div>

                    <form class="m-login__form m-form">

                        <div class="form-group m-form__group">
                            <input class="form-control m-input" id="username" type="text" placeholder="Username" name="username" autocomplete="off">
                        </div>

                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" id="password" type="password" placeholder="Password" name="password">
                        </div>

                        <div class="row m-login__form-sub">

                            <div class="col m--align-right m-login__form-right">
                                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                    <?php echo get_phrase('forgot_your_password');?> ?
                                </a>
                            </div>
                        </div>

                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                                Sign In
                            </button>
                        </div>
                    </form>

                    <div class="clearfix">&nbsp;</div>

                    <div class="m-login__head">
                        <h5 class="m-login__title" style="font-size:13px;">
                            2017 - <?php echo date('Y');?> BIGSchool ERP By Intellisense Technology Africa V2.0
                        </h5>
                    </div>


                </div>


                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Forgotten Password ?
                        </h3>
                        <div class="m-login__desc">
                            Enter your email to reset your password:
                        </div>
                    </div>


                    <form class="m-login__form m-form" action="" method="post">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" id="m_email" type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                <?php echo get_phrase('reset_password'); ?>
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">
                                Cancel
                            </button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->

<!--<div id="particles-js"></div>-->

<!-- scripts -->
<script src="assets/metronic/js/particles.js"></script>
<!--<script src="assets/metronic/js/app.js"></script>-->

<script src="assets/metronic/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/metronic/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="assets/metronic/js/login.js" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>
