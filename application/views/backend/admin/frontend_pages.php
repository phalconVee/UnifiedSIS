<hr>
<div class="row">

    <?php include 'left_sidebar.php'; ?>

    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">

                <?php echo form_open(base_url() . 'index.php?admin/frontend_settings/update_general_settings' ,
                    array('class' => 'form-horizontal form-groups-bordered','target'=>'_top'));?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('school_title');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="school_title" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'school_title'))->row()->description;?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('school_email');?></label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" name="school_email" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'school_email'))->row()->description;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="phone" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'phone'))->row()->description;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('copyright_text');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="copyright_text" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'phone'))->row()->description;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="address" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'address'))->row()->description;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('geo_code');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="school_location" placeholder="latitude, longitude"
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'geo_code'))->row()->description;?>">
                        </div>
                    </div>

                    <!-- getting the social links -->
                    <!-- getting the social links -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('social_links');?></label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <input type="text" class="form-control" name="facebook" placeholder=""
                                       value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'facebook_profile'))->row()->description;?>">
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-facebook"></i></a>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <input type="text" class="form-control" name="twitter" placeholder=""
                                       value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'twitter_profile'))->row()->description;?>">
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-twitter"></i></a>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <input type="text" class="form-control" name="linkedin" placeholder=""
                                       value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'linkedin_profile'))->row()->description;?>">
                                <div class="input-group-addon">
                                    <a href="#"><i class="entypo-linkedin"></i></a>
                                </div>
                            </div>
                            <br>

                            <div class="input-group">
                                <input type="text" class="form-control" name="google" placeholder=""
                                       value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'google_profile'))->row()->description;?>">
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('homepage_note_title');?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="homepage_note_title" placeholder=""
                                   value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'homepage_note_title'))->row()->description;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('homepage_note_description');?></label>
                        <div class="col-sm-7">
                            <textarea class="form-control" name="homepage_note_description" rows="5">
                                <?php echo $this->db->get_where('settings_frontend' , array('type' =>'homepage_note_description'))->row()->description;?>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-7">

                            <button type="submit" class="btn btn-success">
                                <i class="entypo-check"></i> &nbsp; <?php echo get_phrase('save');?>
                            </button>
                        </div>
                    </div>

                <?php echo form_close();?>


            </div>
        </div>
    </div>
</div>

