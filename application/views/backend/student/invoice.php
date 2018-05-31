<div class="row">
	<div class="col-md-12">

    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
					<?php echo get_phrase('invoice/payment_list');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table  class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('student');?></div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>
                    		<th><div><?php echo get_phrase('description');?></div></th>
                    		<th><div><?php echo get_phrase('amount');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th width="330"><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php foreach($invoices as $row):?>
                        <tr>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php echo $row['amount'];?></td>
							<td>
								<span class="label label-<?php if($row['status']=='paid')echo 'success';else echo 'danger';?>"><?php echo $row['status'];?></span>
							</td>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>

                                <div class="row">

                                    <!--<div class="col-md-6">
                                      <?php echo form_open('student/invoice/make_payment');?>
                                            <input type="hidden" name="invoice_id" 		value="<?php echo $row['invoice_id'];?>" />
                                                <button type="submit" class="btn btn-info" <?php if($row['status'] == 'paid'):?> disabled="disabled"<?php endif;?>>
                                                      <i class="entypo-paypal"></i> Pay with paypal
                                                  </button>
                                      </form>
									</div>-->

									<div class="col-md-6">
										<a href="<?php echo base_url('index.php?student/pay_with_payumoney/'.$row['student_id'].'/'.$row['invoice_id']);?>" type="button" class="btn btn-success"> <?php echo get_phrase('pay_with_payumoney') ?></a>
									</div>

                                    <div class="col-md-6">
                                        <form >
                                            <script src="https://js.paystack.co/v1/inline.js"></script>
                                            <button type="button" class="btn btn-info" onclick="payWithPaystack()"> Pay with Paystack </button>
                                        </form>

                                    </div>

								</div>
        			</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->




		</div>
	</div>
</div>

<!--Paystack inline JS code -->
<script>
    function payWithPaystack(){
        var handler = PaystackPop.setup({
            key: 'pk_live_d75bd45a72bd2b4f50754f45d1aa11a9356b88e6',
            email: 'phalcon.vee@gmail.com',
            amount: 10000,
            //ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {
                        display_name: "Mobile Number",
                        variable_name: "mobile_number",
                        value: "+2348012345678"
                    }
                ]
            },
            callback: function(response){
                alert('success. transaction ref is ' + response.reference);
            },
            onClose: function(){
                alert('window closed');
            }
        });
        handler.openIframe();
    }
</script>
<!--end-->