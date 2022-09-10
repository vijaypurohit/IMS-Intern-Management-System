<?php
// FOOTER FILES
?>

    <!-- Jquery Core Js -->
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/bootstrap/js/bootstrap.js"></script>

<?php if(isset($bootstrap_select) && $bootstrap_select==1) : ?>
    <!-- Select Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<?php $bootstrap_select=0; endif ?>

<?php if(!$from_url_path=='main_login'  || $from_url_path=='admin' || $from_url_path=='intern'): ?>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<?php endif ?>

<?php if(isset($multiSelect) && $multiSelect==1) : ?>
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/multi-select/js/jquery.multi-select.js"></script>
<?php $multiSelect=0; endif ?>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/node-waves/waves.js"></script>

<?php if(isset($jqueryValidate) && $jqueryValidate==1) : ?>
    <!-- Validation Plugin Js -->
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/jquery-validation/jquery.validate.js"></script>
<?php $jqueryValidate=0; endif ?>

<?php if(!$from_url_path=='main_login' || $from_url_path=='admin' || $from_url_path=='intern'): ?>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/js/pages/ui/notifications.js"></script>

    <!-- MOMENT Plugin Js -->
    <script src="<?php echo $asset_path_link; ?>assets/bsb/plugins/momentjs/moment.js"></script>
    <script type="text/javascript">
        var update = function() {
            document.getElementById("datetime")
                .innerHTML = moment().format('MMMM D, YYYY, h:mm a');
        };
        setInterval(update, 1000);
    </script>
<?php endif ?>

<?php if(isset($jqueryDataTable) && $jqueryDataTable==1) : ?>
    <!-- Jquery DataTable Plugin Js Default -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<!-- DATA TABLES NEW-->
        <!-- FOR ROWS GROUPING IN DT -->
    <script src="<?php echo $asset_path_link ?>assets/plugins/DataTables/RowGroup-1.1.0/js/dataTables.rowGroup.min.js"></script>
    <!-- Column Visual on off-->
    <script src="<?php echo $asset_path_link ?>assets/plugins/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
<?php $jqueryDataTable=0; endif ;?>

<?php if(isset($dateTimePicker) && $dateTimePicker==1) : ?>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/autosize/autosize.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<?php $dateTimePicker=0; endif ?>



    <!-- ADMIN Js -->
    <script src="<?php echo $asset_path_link ?>assets/bsb/js/admin.js"></script>
    <script>
        // to prevent post from resubmitting form
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        //Tooltip
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
        //Popover
        $('[data-toggle="popover"]').popover();
    </script>

</body>




