<?php
$invoice_title = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->title;
$due           = $this->db->get_where('invoice', array('student_id' => $student_id, 'invoice_id' => $invoice_id))->row()->due;
$amount_paid   = $this->db->get_where('invoice', array('student_id' => $student_id, 'invoice_id' => $invoice_id))->row()->amount_paid;
$amount        = $this->db->get_where('invoice', array('student_id' => $student_id, 'invoice_id' => $invoice_id))->row()->amount;
$public_key    = $this->db->get_where('settings' , array('type' =>'paystack_public_key'))->row()->description;
$txnref        = $merch_txref;
$txnid         = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
?>

<html>

<head>

</head>

<body>
<div class="row">
    <div class = "col-md-12">

        <br/>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('paystack_payment_form');?>
                </div>
            </div>

            <div class="panel-body form-horizontal form-groups-bordered">
                <h3><?php echo get_phrase('mandatory_parameters'); ?></h3>

                <?php echo form_open(base_url() . 'index.php?paystack/redirectToGateway' ,
                    array('class' => 'form-horizontal form-groups-bordered', 'target'=>'_top'));?>

                <!--<form class = "form-horizontal form-groups-bordered" action="<?=base_url();?>" method="post" >-->

                    <input type="hidden" name="key" value="<?php echo $public_key ?>" id="public_key"/>
                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" id="txnid"/>
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" id="student_id"/>
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" id="invoice_id"/>

                    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
                    <input type="hidden" name="amount_paid" value="<?php echo $amount_paid; ?>" />

                    <div class="form-group">
                        <label  class="col-sm-2 control-label"><?php echo get_phrase('Due_Amount');?></label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="due" id="amount" value="<?php echo $due;?>" max="<?php echo $due;?>" min = "<?php echo $due;?>" required>
                        </div>

                        <label  class="col-sm-2 control-label"><?php echo get_phrase('first_name');?></label>
                        <div class="col-sm-3">
                            <input type = "text" class="form-control" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-2 control-label"><?php echo get_phrase('email');?></label>
                        <div class="col-sm-3">
                            <input class="form-control" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" required/>
                        </div>

                        <label  class="col-sm-2 control-label"><?php echo get_phrase('phone');?></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-sm-2 control-label"><?php echo get_phrase('invoice_title');?></label>
                        <div class="col-sm-7">
                            <textarea class="form-control" name="productinfo" id="productinfo" required><?php echo $invoice_title; ?></textarea>
                        </div>
                    </div>

                    <br>

                     <center>
                         <button type="submit" class="btn btn-success" id="submit"> Pay </button>
                     </center>

                <?php echo form_close();?>

            </div>

        </div>
    </div>

</div>
</body>
</html>
