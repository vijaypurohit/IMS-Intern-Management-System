<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 27-Jun-19
 * Time: 8:58 AM
 * Project: ims_vj
 */

$asset_path_link='../';
$int_pages_link='';

$jqueryDataTable=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (INT_PATH .'/_.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 3px;">
                HISTORY
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Your Projects
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
                            <table  class="table table-bordered table-striped table-hover dataTable project-list-history">
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white">
                                    <th>PROJECT NAME</th>
                                    <th>TEAM</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of members" >#</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>PROJECT NAME</th>
                                    <th>TEAM</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of members">#</th>
                                    <th>CREATED AT</th>
                                    <th>BATCH</th>
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
        <!-- #END# Basic Examples -->
    </div>
</section>

<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- -----------------------------------------HTML FOOTER--------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>

<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- Custom Jquery DataTables CONFIG-->
<script type="text/javascript">
    $(function () {
        var table =  $('.project-list-history').DataTable({
            ajax: "batch_logics.php?&dtShowAllProjectsOfUser="+"projects_list",
            columns: [
                { "data": "project_name" },
                { "data": "team_name" },
                { "data": "num_members" },
                { "data": "created_at" },
                { "data": "batch_name" }
            ],
            deferRender: true,
            scrollY   : '60vh',                    // vertical port view
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[0, 'asc'],[1, 'asc']],
            rowGroup: {
                dataSrc: 'team_name'                 // row grouping based on column
            },
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
                $(row).find('td:eq(0)').addClass('font-bold');
                $(row).find('td:eq(4)').addClass('font-bold');
                $(row).find('td:eq(0)').addClass('col-red');
                $(row).find('td:eq(4)').addClass('col-blue');
                $(row).addClass( "font-14" );
            }
        });
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
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - Projects');
                        $(win.document.body)
                            .css( 'font-size', '12pt' )
                            .prepend(
                                '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    },

                },
            ],
        }).container().appendTo($('#buttonsEx'));

        // on click to open new
        $('.project-list-history tbody').on('click', 'tr', function () {
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

<?php //echo $asset_path_link ?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>
