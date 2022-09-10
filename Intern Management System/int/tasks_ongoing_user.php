<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 09-Jul-19
 * Time: 12:22 PM
 * Project: ims_vj
 */

$asset_path_link='../';     // to link the asset folder with current level.
$int_pages_link='';         // to link the pages in directory to the admin base level pages.
$jqueryDataTable=1;
?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>
<?php // require_once('task_logics.php'); ?>
<?php  // For Double Submit of Form
$_SESSION['form_token'] = md5(session_id() . time() . $_SESSION['user']['id']); ?>

<section class="content">
    <!--    --><?php // include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
    <div class="container-fluid">

        <?php
        $date_year_check = $today_date_year;                          // getting current year
        if (isset($_REQUEST['show_my_task_year'])) {                    // checking if you want to look for different year
            $date_year_check = $_REQUEST['show_my_task_year'];
        }
        ?>

        <!-- task show-->
        <div class="container-fluid" style="padding-top: 25px">
            <div class="block-header">
                <h2 class="com bo"
                    style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                    PENDING TASKS
                </h2>
            </div>

            <!--  All tasks -->
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="card">
                        <div class="header">
                            <h2>
                                All Tasks
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
                                <table id="task_list"  class="table table-bordered table-striped table-hover dataTable show-all-task">
                                    <thead>
                                    <tr style="font-weight: bold; background: #607d8b; color: white">
                                        <th>TITLE</th>
                                        <th>DEADLINE</th>
                                        <th>PROJECT</th>
                                        <th>AT</th>
                                        <th>STATUS</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                        <th>TITLE</th>
                                        <th>DEADLINE</th>
                                        <th>PROJECT</th>
                                        <th>AT</th>
                                        <th>STATUS</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div style="padding-bottom: 20px" class="help-block">red title name - notification not seen,  green title name - notification seen</div>
                </div>

            </div>
            <!-- #END#  All tasks -->

        </div>
        <!-- #END# task show-->


    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Custom Jquery DataTables-->
<script type="text/javascript">

    $(function () {
        var table =  $('.show-all-task').DataTable({
            ajax: "task_logics.php?&dtShowUserAllTasksPending="+"Pending&selectedYear="+ <?php echo $date_year_check?>,
            columns: [
                { "data": "tk_title" },
                { "data": "deadline" },
                { "data": "tk_project" },
                { "data": "formatted_initiate" },
                { "data": "tk_status" }
            ],
            deferRender: true,
            "scrollX": true,
            "autoWidth": false,
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[0, 'asc'],[2, 'asc']],

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
                {
                    targets: 1,
                    className: 'noVis',
                },
            ],
            rowCallback: function(row, data){
                $(row).find('td:eq(0)').addClass(data['dt_row_color_class']);
                $(row).find('td:eq(4)').addClass(data['tk_status_color']);
                $(row).find('td:eq(1)').addClass('font-bold');
                $(row).find('td:eq(4)').addClass('font-bold');
            }

        });
        // document.getElementById('app_title').text = 'TASKS';
        // to show export buttons in header dropdown.
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                'copy', 'csv', 'excel',
                {
                    extend: 'print',
                    text: 'Preview',
                    autoPrint: false,
                    messageTop: 'This print was produced using the ims',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function (win) {
                        // $(win.document.body).find('table').addClass('display');
                        $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                            $(this).css('background-color','#D0D0D0');
                        });
                        $(win.document.body).find('h1').css('text-align','center');
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - TASKS');
                        $(win.document.body)
                            .css( 'font-size', '12pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' )
                        ;
                        // .css( 'margin', '0 auto' )
                        // .css( 'width', '100%' )
                        // .css( 'clear', 'both' )
                        // .css( 'border-collapse', 'collapse' )
                        // .css( 'table-layout', 'fixed' )
                        // .css( 'word-wrap', 'break-word' );

                    },

                },
            ],
        }).container().appendTo($('#buttonsEx'));

        // on click to open new
        $('.show-all-task tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            // console.log( table.row( this ).data() );
            // console.log( data['user_id'] );
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