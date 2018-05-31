<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $system_name    =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $school_title	=	$this->db->get_where('settings_frontend' , array('type'=>'school_title'))->row()->description;
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BIGSchool, Nigeria, ERP, School Management System">
    <meta name="description" content="BIGSchool, Nigeria, ERP, School Management System">
    <meta name="description" content="BIGSchool, Nigeria, ERP, School Management System">
    <meta name="description" content="Intellisense Technology Africa">
    <meta name="author" content="Henry ugochukwu">

    <title><?php echo $meta_title;?> | <?php echo $school_title;?></title>

    <link rel="shortcut icon" href="assets/images/favicon-4.png">


    <link href="<?=base_url();?>assets/theme/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="<?=base_url();?>assets/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="<?=base_url();?>assets/theme/css/vendors.css" type="text/css" rel="stylesheet">
    <!--<link href="<?=base_url();?>assets/theme/css/style.css" type="text/css" rel="stylesheet">-->


    <?php
    $skin_colour = $this->db->get_where('settings_frontend' , array('type' => 'skin_colour'))->row()->description;
    if ($skin_colour != ''):?>
        <link href="<?=base_url();?>assets/theme/css/style-<?php echo $skin_colour;?>.css" type="text/css" rel="stylesheet" id="style">
        <link href="<?=base_url();?>assets/theme/css/components-<?php echo $skin_colour;?>.css" type="text/css" rel="stylesheet" id="components">
    <?php endif;?>


    <!--Slider Revolution -->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/theme/slider-revolution/css/settings.css" >
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/theme/slider-revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/theme/slider-revolution/css/navigation.css">

    <!--Google Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Oswald:300,700,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Respond.js and HTML shiv provide HTML5 support in older browsers like IE9 and 8 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        /* Pagination */
        div.pagination {
            padding:2px;
            margin: 20px 10px;
            float: right;
        }
        div.pagination a {
            margin: 2px;
            padding: 0.5em 0.64em 0.43em 0.64em;
            background-color: #272f6d;
            text-decoration: none;
            color: #fff;
        }
        div.pagination a:hover, div.pagination a:active {
            padding: 0.5em 0.64em 0.43em 0.64em;
            margin: 2px;
            background-color: #272f6d;
            color: #fff;
        }
        div.pagination span.current {
            padding: 0.5em 0.64em 0.43em 0.64em;
            margin: 2px;
            background-color: #f6efcc;
            color: #6d643c;
        }
        div.pagination span.disabled {
            display:none;
        }
        .pagination ul li{display: inline-block;}
        .pagination ul li a.active{opacity: .5;}

        /* loading */
        .loading{position: absolute;left: 0; top: 0; right: 0; bottom: 0;z-index: 2;background: rgba(255,255,255,0.7);}
        .loading .content {
            position: absolute;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            top: 50%;
            left: 0;
            right: 0;
            text-align: center;
            color: #555;
        }
    </style>

    <?php if($navigation == 'admissions'): ?>
        <style>
            .block-title {
                margin-left: -20px;
                margin-right: -20px;
                padding: 5px;
                position: relative;
                color: #fff;
                margin-bottom: 20px;
                z-index: 2;
                background: #152736 !important;
            }

            .student-img {
                height: 130px;
                width: 100px;
                margin-left: auto;
                border: 2px solid #6b6b6b;
                padding: 10px;
                padding-top: 50px;
                float: right;
            }

            .form-body {
                border: 2px solid #152736;
                margin-top: 20px;
                padding: 0px 20px 5px 20px;
            }

            .form-body .input-title {
                float: left;
                margin-right: 8px;
            }

            .form-body .form-field {
                overflow: hidden;
                border-bottom: 1px dotted #708596;
                min-height: 20px;
            }

        </style>

    <?php endif; ?>

</head>

<body class="home">

    <!---Load loader backdrop -->
    <?php if($navigation == 'home'): ?>
        <div class="loader-backdrop">
            <div class="loader">
                <div class="ball-1"></div>
                <div class="ball-2"></div>
            </div>
        </div>
    <?php endif;?>

    <!-- call header file -->
    <?php $this->load->view($header); ?>

    <!-- check if slider file is required for page-->
    <?php if(!empty($slider)): ?>
        <?php $this->load->view($slider); ?>
    <?php endif; ?>


    <!-- load page content -->
    <?php $this->load->view($page_content); ?>

    <!-- load footer file -->
    <?php $this->load->view($footer); ?>


</body>
</html>
