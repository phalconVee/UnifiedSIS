<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
<link href="<?=base_url();?>assets/theme/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700">

<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/neon-core.css">
<link rel="stylesheet" href="assets/css/neon-theme.css">
<link rel="stylesheet" href="assets/css/neon-forms.css">

<link rel="stylesheet" href="assets/css/custom.css">

<?php
    $skin_colour = $this->db->get_where('settings' , array(
        'type' => 'skin_colour'
    ))->row()->description;
    if ($skin_colour != ''):?>

    <link rel="stylesheet" href="assets/css/skins/<?php echo $skin_colour;?>.css">

<?php endif;?>

<?php if ($text_align == 'right-to-left') : ?>
    <link rel="stylesheet" href="assets/css/neon-rtl.css">
<?php endif; ?>

<script src="assets/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="assets/js/Chart.js"></script>
<script src="assets/js/jquery.PrintArea.js"></script>

<?php if($page_name == 'student_id_card' || $page_name == 'teacher_id_card'){ ?>

    <style type="text/css">

        .area{
            width: 730px;
            height: 520px;
            margin-top: 0px;
            border: 1px solid #AAA;
        }
        .side{
            width: 350px;
            height: 500px;
            margin-left: 10px;
            margin-top: 10px;
            border: 1px solid #AAA;
            border-radius: 10px;
            float: left;
        }
        img{
            margin-top: 15px;
        }
        .title{
            font-size: 20px;
            color: #176CB4;
            margin-top: 8px;
            font-weight: bold;
        }
        .title_bottom{
            font-size: 14px;
            color: #999;
            font-weight: bold;
        }
        .photo{
            /*border: 1px solid #AAA;*/
            border-radius: 5px;
            border: none;
            margin-top: 4px;
        }
        .title input{
            border: none;
            font-size: 22px;
            text-align: center;
        }
        .title p{
            font-size: 22px;
            border: none;
            text-align: center;
        }
        .title_bottom input{
            border: none;
            width: 300px;
            text-align: center;
        }
        .title_bottom p{
            border: none;
            width: 300px;
            text-align: center;
            font-size: 14px;
        }
        .name{
            font-size: 20px;
            color: #020230;
            margin-top: 4px;
            font-weight: bold;
        }
        .name input{
            border: none;
            width: 300px;
            text-align: center;
        }
        .name p{
            font-size: 20px;
            border: none;
            width: 300px;
            text-align: center;
        }
        label{
            color: #2E4F4F;
            height: 16px;
        }
        .detail-content{
            margin-left: 35px;
        }
        .detail-content input{
            color: #999;
        }
        .detail-content p{
            color: #999;
        }
    </style>
    <style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        margin-top: 400px;
        padding: 20px;
        border: 1px solid #888;
        width: 770px;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        height: 18px;
        margin-top: -10px;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <!--<script type="text/javascript" src="assets/js/html2canvas.js"></script>-->
<?php } ?>


<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<link rel="shortcut icon" href="assets/images/favicon-4.png">
<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="assets/js/vertical-timeline/css/component.css">
<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">

<link rel="stylesheet" href="assets/js/wysihtml5/bootstrap-wysihtml5.css">

<!--Amcharts-->
<script src="<?php echo base_url();?>assets/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/gauge.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/funnel.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/radar.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/amexport.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/canvg.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/jspdf.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/filesaver.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>

<script>
    function checkDelete()
    {
        var chk=confirm("Are You Sure To Delete This !");
        if(chk)
        {
          return true;
        }
        else{
            return false;
        }
    }
</script>
