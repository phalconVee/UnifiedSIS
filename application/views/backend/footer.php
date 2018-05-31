<?php
$system_name   = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
$system_title  = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
?>

<!-- Footer -->
<footer class="main">
	<strong><?php echo $system_name;  ?> </strong>
	Powered by <a href="http://intellisense.com.ng"
    	target="_blank">BIGSchool</a> &copy;<?=date('Y');?> Intellisense Technology Africa
</footer>
