<div class="page-header">
    <div class="container">
        <h1>Admission Process</h1>
        <ul class="breadcrumb">
            <li><a href="<?=base_url();?>">Home</a></li>
            <li class="active">Admission Process</li>
        </ul>
    </div>
</div>

<div class="process-2 mt-100 mb-100">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 process-box">
                <div class="process-cell bgcolor3">
                    <span class="color1 abs-center font22">START</span>
                </div>
                <div class="process-cell">
                    <h6><i class="fa fa-edge icon-round icon-fill"></i> <strong>Fill Form</strong></h6>
                    <p>Print and fill admission form online.</p>
                </div>
            </div>
            <div class="col-sm-3 process-box">
                <div class="process-cell">
                    <h6><i class="fa fa-credit-card icon-round icon-fill"></i> <strong>Submit Form</strong></h6>
                    <p>Submit form at school or via the school's email address.</p>
                </div>
                <div class="process-cell empty">
                </div>
            </div>
            <div class="col-sm-3 process-box">
                <div class="process-cell empty">
                </div>
                <div class="process-cell">
                    <h6><i class="fa fa-calendar-check-o icon-round icon-fill"></i> <strong>Get Notification</strong></h6>
                    <p>Get notification for entrance examination</p>
                </div>
            </div>
            <div class="col-sm-3 process-box">
                <div class="process-cell">
                    <h6><i class="fa fa-hand-pointer-o icon-round icon-fill"></i> <strong>Check Admission Status</strong></h6>
                    <p>You will be notified of your admission status online/offline when due.</p>
                </div>
                <div class="process-cell bgcolor3">
                    <span class="color1 abs-center font22">FINISH</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="container mb-100">

    <div class="admission-form-wrapper" id="form-print">
        <div class="row">
            <div class="col-sm-12">

                <div class="form-head clearfix">
                    <div class="school-info pull-left w-50">
                        <img src="<?php echo base_url();?>image.php/uploads/logo.png?width=200&height=50&cropratio=1:1&image=<?php echo base_url();?>uploads/logo.png" title="logo" alt="logo" class="img-responsive" />

                        <h2><?=$school_title;?></h2>
                        <p><?=$address;?></p>
                        <p><?=$phone;?></p>
                        <h3 class="">Admission Form</h3>
                    </div>
                    <div class="student-img-wrapper text-center pull-right w-50">
                        <div class="student-img">
                            <p>Student Photo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">

                <div class="form-body">
                    <div class="block-title text-center">
                        <h4>Student Information</h4>
                    </div>

                    <div class="clearfix">
                        <div class="input-title">Student Name :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Home Address :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Gender :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Birthday :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Father's Name :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Mobile Num :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Mother's Name :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Mobile Num :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">

                        <div class="input-title">Religion :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Nationality :</div> <div class="form-field"></div>
                    </div>

                    <div class="clearfix mt-20">
                        <div class="input-title">Educational Background :</div> <div class="form-field"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="print-btn text-center mt-20">
                    <button type="button" class="btn btn-default" onclick="printDiv('form-print')">Print</button>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="clearfix"></div>
