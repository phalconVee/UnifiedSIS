
<div class="form-group">
    <div class="col-md-2">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section');?></label>
        <select name="section_id_1" id="section_id_1" class="form-control selectboxit">
            <?php
            $sections = $this->db->get_where('section' , array(
                'class_id' => $class_id
            ))->result_array();
            foreach($sections as $row):
                ?>
                <option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>