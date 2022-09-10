<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 08-Jun-19
 * Time: 7:45 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$int_pages_link='';
$bootstrap_select=1;
$jqueryDataTable=1;
$dateTimePicker=1;
//require_once(INCLUDE_PATH . "/logic/common_functions.php");
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php  require_once("intern_logic.php") ?>
<?php
// For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']);
?>
<style>
    #show_table{
        margin: 0 auto;
        width: 100%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap:break-word;
    }
    /*table.dataTable tbody td {*/
    /*    white-space: nowrap;*/
    /*}*/
</style>
<section class="content">
    <!-- LEAVE INITIATE -->
    <div class="container-fluid" style="padding-top: 25px">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                Initiate Leave
            </h2>
        </div>

        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- Leave Form -->
        <form id="form_insert_leave" action="intern_leaves.php" method="post">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Apply For Leave
                        </h2>
                    </div>
                    <div class="body">
                        <!--DATE-->
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-12 col-md-12">
<!--                                <div class="">-->
                                    <h2 class="card-inside-title">Range</h2>
                                    <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="from_date" placeholder="Date start..." required>
                                        </div>
                                        <span class="input-group-addon">to</span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="to_date" placeholder="Date end..." required>
                                        </div>
                                    </div>
<!--                                </div>-->
                            </div>
                        </div>
                        <!--END DATE-->
                        <!--Leave Reason-->
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea style="height:60px; border: 1px solid #cc3128;" id="leave_reason" onkeyup="countChar(this)" class="form-control" placeholder="Type Your Leave Reason Here" name="leave_reason" minlength="2" required="required"></textarea>
                                    </div>
                                    <label class="form-label" style="text-align: right; font-weight: normal; padding-top: 10px;" id="charNum"> </label>
                                </div>
                            </div>
                        </div>
                        <!-- #END# Reason-->

                        <input type="hidden" name="form_token" value="<?php echo $_SESSION['form_token'] ?>" />

                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-4 col-sm-offset-8 col-md-3 col-md-offset-9" style="margin-bottom: 0px;">
                        <button class="btn btn-block btn-lg bg-deep-purple waves-effect" name="submit_leave" id="submit_leave" type="submit">SUBMIT</button>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <hr>
                            <div class="col-xs-12 col-sm-12 col-md-12 help-block">
                                <li>
                                    Learning Loss of classes will be bear on your own Rish & Responsibility.
                                </li>
                                <li>
                                    I understand that until both my Faculty or and the HR sign this form, my leave is not approved.
                                </li>
                                <li>
                                    Maintaining 75% attendance is must, otherwise extra days will be added.
                                </li>
                                <li>
                                    Stipend Amount will be deducted based on Number of days.
                                </li>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- #END# Leave Form -->
        </form>
        <input type="hidden" id="intern_name" value="<?php echo $user['full_name']?>" />
        <input type="hidden" id="intern_email" value="<?php echo $user['email']?>" />
    </div>
    <!-- #end# LEAVE INITIATE-->

</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->

<!-- CUSTOM SETTINGS DATETIME Js -->
<script type="text/javascript">
    $(function () {
        //Textarea auto growth
        autosize($('textarea.auto-growth'));

        //Bootstrap datepicker plugin
        $('#bs_datepicker_range_container').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            startDate: "<?php echo date('d-m-Y') ?>",
            daysOfWeekDisabled: "0,6",
            daysOfWeekHighlighted: "0,6",
            calendarWeeks: true,
            todayHighlight: true,
            todayBtn: true,
            clearBtn: true,
            // datesDisabled: ['10-06-2019', '06-21-2019'],
            container: '#bs_datepicker_range_container'
        });
    });

    function countChar(val) {
        var len = val.value.length;
        if (len >= 500) {
            val.value = val.value.substring(0, 500);
            document.getElementById('submit_leave').disabled = true;
        } else {
            document.getElementById('submit_leave').disabled = false;
            $('#charNum').text(len + ' Characters Used');
        }
    }
</script>

<!-- Custom Jquery DataTables-->
<script type="text/javascript">
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    //Popover
    $('[data-toggle="popover"]').popover();

    function dashInternLeave(id) {
        window.location = "intern_leaves.php?show_my_leave_year=" + id;
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
