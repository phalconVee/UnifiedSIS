
<hr>
<div class="row">

    <?php include 'left_sidebar.php'; ?>


    <div class="col-md-10">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3><?php echo get_phrase('homepage_slider_settings');?></h3>
                <hr />

                <?php echo form_open(base_url() . 'index.php?admin/frontend_settings/update_slider_images' ,
                    array('class' => 'form-horizontal form-groups', 'target' => '_top', 'enctype' => 'multipart/form-data'));?>

                    <strong>Slider Image - 1</strong>
                    <div class="row" style="margin-top: 20px;">

                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title_0" placeholder="Title"
                                           value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_title_0'))->row()->description;?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description_0" rows="5" class="form-control" required>
                                        <?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_title_1'))->row()->description;?>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Slider Image
                                    <small>(1950px X 320px)</small>
                                </label>
                                <div class="col-sm-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                            <img src="<?php echo base_url();?>uploads/frontend/slider/0.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                              <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select Image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="slider_image_0" accept="image/*">
                                              </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <hr>
                    <strong>Slider Image - 2</strong>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title_1" placeholder="Title"
                                           value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_title_1'))->row()->description;?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description_1" rows="5" class="form-control" required>
                                        <?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_description_1'))->row()->description;?>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Slider Image
                                    <small>(1950px X 320px)</small>
                                </label>
                                <div class="col-sm-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                            <img src="<?php echo base_url();?>uploads/frontend/slider/1.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                              <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select Image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="slider_image_1" accept="image/*">
                                              </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <hr>
                    <strong>Slider Image - 3</strong>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-7">

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title_2" placeholder="Title"
                                           value="<?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_title_2'))->row()->description;?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description_2" rows="5" class="form-control" required>
                                        <?php echo $this->db->get_where('settings_frontend' , array('type' =>'slider_description_2'))->row()->description;?>
                                    </textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label">Slider Image
                                    <small>(1950px X 320px)</small>
                                </label>
                                <div class="col-sm-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                            <img src="<?php echo base_url();?>uploads/frontend/slider/2.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                          <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="slider_image_2" accept="image/*">
                                          </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success">
                        <i class="entypo-check"></i>  &nbsp; <?php echo get_phrase('save');?>  </button>

                <?php echo form_close();?>

            </div>
        </div>
    </div>
</div>
