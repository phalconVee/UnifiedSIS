<?php
$edit_data = $this->db->get_where('staff_salary' , array('id' => $param2))->result_array();
foreach ($edit_data as $row):
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-plus-circled"></i>
                        <?php echo get_phrase('edit_staff_salary');?>
                    </div>
                </div>

                <div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?accountant/staffSalary/edit/' . $row['id'] , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('year');?></label>

                        <div class="col-sm-5">
                            <select name="year" class="form-control">

                                <option value=""><?php echo get_phrase('select_salary_year');?></option>
                                <?php for($i = 0; $i < 20; $i++):?>
                                    <option value="<?php echo (2012+$i);?>"
                                        <?php if($row['year'] == (2012+$i)) echo 'selected';?>>
                                        <?php echo (2012+$i);?>
                                    </option>
                                <?php endfor;?>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('month');?></label>

                        <div class="col-sm-5">
                            <select name="month" class="form-control" data-validate="required">
                                <?php
                                $month = $this->db->get_where('staff_salary' , array('month' => $row['month']))->row()->month;
                                ?>
                                <option value=""><?php echo get_phrase('select_salary_month');?></option>

                                <option value="january" <?php if($month == 'january')echo 'selected';?>><?php echo get_phrase('january');?></option>

                                <option value="february" <?php if($month == 'february')echo 'selected';?>><?php echo get_phrase('february');?></option>

                                <option value="march" <?php if($month == 'march')echo 'selected';?>><?php echo get_phrase('march');?></option>

                                <option value="april" <?php if($month == 'april')echo 'selected';?>><?php echo get_phrase('april');?></option>

                                <option value="may" <?php if($month == 'may')echo 'selected';?>><?php echo get_phrase('may');?></option>

                                <option value="june" <?php if($month == 'june')echo 'selected';?>><?php echo get_phrase('june');?></option>

                                <option value="july" <?php if($month == 'july')echo 'selected';?>><?php echo get_phrase('july');?></option>

                                <option value="august" <?php if($month == 'august')echo 'selected';?>><?php echo get_phrase('august');?></option>

                                <option value="september" <?php if($month == 'september')echo 'selected';?>><?php echo get_phrase('september');?></option>

                                <option value="october" <?php if($month == 'october')echo 'selected';?>><?php echo get_phrase('october');?></option>

                                <option value="november" <?php if($month == 'november')echo 'selected';?>><?php echo get_phrase('november');?></option>

                                <option value="december" <?php if($month == 'december')echo 'selected';?>><?php echo get_phrase('december');?></option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('start_date');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control datepicker" name="start_date" placeholder= "mm/dd/yyyy" value="<?=$row['start_date'];?>" data-start-view="2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-5" class="col-sm-3 control-label"><?php echo get_phrase('end_date');?></label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control datepicker" name="end_date" placeholder= "mm/dd/yyyy" value="<?=$row['end_date'];?>" data-start-view="2">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-default"><?php echo get_phrase('update');?></button>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>
