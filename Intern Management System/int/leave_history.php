<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 18-Jun-19
 * Time: 12:24 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$int_pages_link='';
$bootstrap_select=1;
$jqueryDataTable=1;
$dateTimePicker=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php  require_once('intern_logic.php'); ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>
<!--<style>-->
<!--    table{-->
<!--        margin: 0 auto;-->
<!--        width: 100%;-->
<!--        clear: both;-->
<!--        border-collapse: collapse;-->
<!--        table-layout: fixed;-->
<!--        word-wrap:break-word;-->
<!--    }-->
<!--</style>-->

<section class="content">
    <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>

    <div class="container-fluid" style="padding-top: 25px">
        <?php
        $date_year_check = $today_date_year;                          // getting current year
        if (isset($_REQUEST['show_my_leave_year'])) {                    // checking if you want to look for different year
            $date_year_check = $_REQUEST['show_my_leave_year'];
        }

        ?>
        <!-- MY LEAVE SHOW-->
        <div class="container-fluid" style="padding-top: 25px">
            <div class="block-header">
                <h2 class="com bo"
                    style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                    MY LEAVES
                </h2>
            </div>
            <?php $years = range( "2018", date('Y')); ?>
            <div class="col-sm-12">
                <select class="form-control show-tick" name="batch_year" onchange='dashInternLeave(this.value)' required>
                    <option>Select Year</option>
                    <?php foreach($years as $year) : ?>
                        <option value="<?php echo $year; ?>" <?php echo $year==$date_year_check? 'selected' : '' ?>><?php echo $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div><!--year-->
            <!--  All Leaves -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                All Leaves
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right" >
                                        <li><a id="buttonsEx"></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--                    <div class="col-sm-6"></div>-->
                        <div class="body">
                            <div class="table-responsive">
                                <table id="show_table" class="table table-bordered table-striped table-hover dataTable show-intern-leave">
                                    <thead>
                                    <tr style="font-weight: bold; background: #607d8b; color: white">
                                        <th>INITIATED</th>
                                        <th>(f-t)</th>
                                        <th>REASON</th>
                                        <th>STATUS</th>
                                        <th>BY</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                        <th>INITIATED</th>
                                        <th>(f-t)</th>
                                        <th>REASON</th>
                                        <th>STATUS</th>
                                        <th>BY</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END#  All Leaves -->
        </div>
        <!-- #END# MY LEAVE SHOW-->
    </div>
    <!-- #END# HISTORY LEAVE SHOW-->
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<!-- Custom Jquery DataTables-->
<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    //Popover
    $('[data-toggle="popover"]').popover();

    function dashInternLeave(id) {
        window.location = "leave_history.php?show_my_leave_year=" + id;
    }


    $(function () {
        // let intern_name = document.getElementById("intern_name").value;
        // let intern_email = document.getElementById("intern_email").value;
        var table =  $('.show-intern-leave').DataTable({
            ajax: "intern_logic.php?&dtShowUserLeaves="+"leave_list&selectedYear="+ <?php echo $date_year_check?>,
            columns: [
                { "data": "formatted_initiate" },
                { "data": "formatted_dateTime" },
                { "data": "le_reason" },
                { "data": "le_status" },
                { "data": "le_approved_name" }
            ],
            deferRender: true,
            scrollY   : '60vh',                    // vertical port view
            "scrollX": true,
            "autoWidth": false,
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[3, 'asc'],[0, 'asc']],
            // rowGroup: {
            //     dataSrc: 'le_status'                 // row grouping based on column
            // },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 pull-right'p>>",
            // column visibility button
            buttons: [
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                },
            ],
            columnDefs: [
                // {
                //     targets: 2,
                //     render: function (data, type, row) {
                //         return data.substr(0, 100);
                //     }
                // },
                {
                    targets: 1,
                    className: 'noVis',
                },
            ],
            rowCallback: function(row, data){
                $(row).find('td:eq(3)').addClass(data['dt_row_color_class']);
                $(row).find('td:eq(4)').addClass(data['dt_row_color_class']);
                $(row).find('td:eq(3)').addClass('font-bold');
                $(row).find('td:eq(4)').addClass('font-italic');
            }

        });
        // document.getElementById('app_title').text = 'LEAVES';
        // to show export buttons in header dropdown.
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                'copy', 'csv', 'excel',
                {
                    extend: 'print',
                    text: 'Preview',
                    autoPrint: false,
                    messageTop: 'This print was produced using the cdac ims',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (win) {
                        // $(win.document.body).find('table').addClass('display');
                        $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                            $(this).css('background-color','#D0D0D0');
                        });
                        $(win.document.body).find('h1').css('text-align','center');
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - LEAVES');
                        $(win.document.body)
                            .css( 'font-size', '12pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );
                        $(win.document.body)
                            .append(
                                "<div role='tabpanel' class='tab-pane animated flipInX ' id='credential'> " +
                                "<div class='row clearfix' style='padding-top: 10px;'> " +
                                "<div class='col-xs-12 col-sm-6 col-md-6'> " +
                                "<div class='col-xs-5 col-sm-4 col-md-4 '> " +
                                "<label class='to'>Name: </label> " +
                                "</div> " +
                                "<div class='col-xs-7 col-sm-8 col-md-8 '> " +
                                "<label class='tp'>" + "<?php echo $user['full_name']?>" +
                                "</label>  " +
                                "</div> " +
                                "</div> " +
                                "<div class='col-xs-12 col-sm-6 col-md-6 '> " +
                                "<div class='col-xs-5 col-sm-4 col-md-4 '> " +
                                "<label class='to'>Email: </label> " +
                                "</div> " +
                                "<div class='col-xs-7 col-sm-8 col-md-8 '> " +
                                "<label class='tp'>" + "<?php echo $user['email']?>"+
                                "</label> " +
                                "</div> " +
                                "</div> " +
                                "</div>"
                            );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                        // .css( 'table-layout', 'fixed' )
                        // .css( ' border-collapse', 'collapse' )
                        // .css( ' width', '100%' )
                        // .css( ' margin', '0 auto' )
                        // .css( '  word-wrap', 'break-word' );
                    },

                },
            ],
        }).container().appendTo($('#buttonsEx'));


        $('.show-intern-leave tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            window.open(
                data['url'],
                '_blank' // <- This is what makes it open in a new window.
            );
        });
    });
    // render buttons as button tag
    $.fn.dataTable.Buttons.defaults.dom.button.tag = 'button';


</script>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
