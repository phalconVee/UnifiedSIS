<?php
$invoice_title = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row()->title;
$due           = $this->db->get_where('invoice', array('student_id' => $student_id, 'invoice_id' => $invoice_id))->row()->due;
$public_key    = $this->db->get_where('settings' , array('type' =>'paystack_merchant_key'))->row()->description;
$txnref        = $merch_txref;
$txnid         = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
?>

<html>

<head>
    <script>
        function payWithPaystack() {

            var name  = $("#firstname").val();
            var email  = $("#email").val();
            var phone  = $("#phone").val();
            var amount = $("#amount").val();
            var txnid  = $("#txnid").val();

            var public_key  = $("#public_key").val();
            var student_id  = $("#student_id").val();
            var invoice_id  = $("#invoice_id").val();

            var handler = PaystackPop.setup({
                key: public_key,
                firstname: name,
                email: email,
                phone: phone,
                amount: amount,
                currency: 'NGN',
                ref: txnid,
                metadata: {
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                            value: phone"
                        }
                    ]
                },
                callback: function (response) {
                    window.location.replace("<?=base_url("index.php?paystack/on_success/'+student_id+'/'+invoice_id+'");?>");
                },
                onClose: function () {
                    alert('window closed');
                }
            });
            handler.openIframe();
        }
    </script>

</head>

<body onload="payWithPaystack()">
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

                <form class = "form-horizontal form-groups-bordered">

                    <script src="https://js.paystack.co/v1/inline.js"></script>

                    <input type="hidden" name="key" value="<?php echo $public_key ?>" id="public_key"/>
                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" id="txnid"/>
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" id="student_id"/>
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" id="invoice_id"/>

                    <div class="form-group">
                        <label  class="col-sm-2 control-label"><?php echo get_phrase('Due_Amount');?></label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="amount" id="amount" value="<?php echo $due;?>" max="<?php echo $due;?>" min = "<?php echo $due;?>" required>
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

                    <button type="button" class="btn btn-success" id="submit" onclick="payWithPaystack()"> Pay </button>

                </form>
            </div>

        </div>
    </div>

</div>
</body>
</html>
