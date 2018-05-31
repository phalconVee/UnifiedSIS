
<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/rickshaw/rickshaw.min.js"></script>
<script src="assets/js/raphael-min.js"></script>
<script src="assets/js/morris.min.js"></script>
<script src="assets/js/jquery.peity.min.js"></script>
<script src="assets/js/neon-charts.js"></script>
<script src="assets/js/jquery.sparkline.min.js"></script>
<script src="assets/js/neon-chat.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>
<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>


<!-- SHOW TOASTR NOTIFICATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

    <script type="text/javascript">
        toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
    </script>

<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>

    <script type="text/javascript">
        toastr.error('<?php echo $this->session->flashdata("error_message");?>');
    </script>

<?php endif;?>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var datatable = $("#table_export").dataTable();

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>