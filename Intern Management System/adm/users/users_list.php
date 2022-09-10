<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 5/27/2019
 * Time: 1:24 PM
 * Project: ims_vj
 */

$asset_path_link='../../';
$adm_pages_link='../';

$jqueryDataTable=1;

?>
<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 3px;">
                USERS
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Users
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
                            <table  class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white">
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>POSITION</th>
                                    <th>REGISTER TIME</th>
<!--                                    <th>VIEW</th>-->
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>POSITION</th>
                                    <th>REGISTER TIME</th>
<!--                                    <th>VIEW</th>-->
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
        var table =  $('.js-basic-example').DataTable({
            ajax: "user_logic.php?&dtShowAllUsers="+"user_list",
            columns: [
                { "data": "full_name" },
                { "data": "email" },
                { "data": "role" },
                { "data": "created_at" }
            ],
            deferRender: true,
            scrollY   : '60vh',                    // vertical port view
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[2, 'asc'],[0, 'asc']],
            rowGroup: {
                dataSrc: 'role'                 // row grouping based on column
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'B><'col-sm-12 col-md-4 pull-right'p>>",
            // column visibility button
            buttons: [
            //     {
            //         extend: 'collection',
            //         text: 'Export',
            //         autoClose: true,
            //         buttons: [
            //             'copy', 'excel', 'csv', 'pdf', 'print',
            //             {
            //                 extend: 'print',
            //                 autoPrint: false,
            //                 exportOptions: {
            //                     columns: ':visible'
            //                 }
            //             }
            //         ]
            //     }
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
                $(row).find('td:eq(2)').addClass(data['dt_row_color_class']);
                $(row).find('td:eq(2)').addClass('font-bold');
                $(row).find('td:eq(0)').addClass('font-italic');
                $(row).addClass( "font-14" );
            }
        });
        // to show export buttons in header dropdown.
        // document.getElementById('app_title').text = 'USERS';
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
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - USERS');
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
        $('.js-basic-example tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            // console.log( table.row( this ).data() );
            // console.log( data['user_id'] );
            window.open(
                'user_profile_view.php?uid='+data['user_id'],
                '_blank' // <- This is what makes it open in a new window.
            );
        });

    });
    // render buttons as button tag
    $.fn.dataTable.Buttons.defaults.dom.button.tag = 'button';
    // $('.js-basic-example').resize();
    //Exportable table
    // $('.js-exportable').DataTable({
    //     dom: 'Bfrtip',
    //     responsive: true,
    //     buttons: [
    //         'copy', 'csv', 'excel', 'pdf', 'print'
    //     ]
    // });

</script>

<?php //echo $asset_path_link ?>
<!-- ------------------------------------------END HTML FOOTER --------------------------------------------------------------- -->
</html>

    <!--                               --><?php
//                                foreach ($all_users as $au){
////
//                                    $color_text = 'col-red';
//                                    if($au['role'] == 'Administrator')
//                                        $color_text = 'col-red';
//                                    elseif($au['role'] == 'Manager')
//                                        $color_text = 'col-blue';
//                                    elseif($au['role'] == 'Employee')
//                                        $color_text = 'col-orange';
//                                    else
//                                        $color_text = 'col-green';
//
//                                    $d = new DateTime($au['created_at']);
//                                    $formatted_date = $d->format('M, d Y'); // 05-Sep-2018
//                                    $formatted_time = $d->format('h:i A'); // 11:18 AM
//
//                                echo "<tr class='font-14' data-toggle='tooltip' data-placement='bottom' title='2. To Upload To Server'>";
//
//                                    echo  "<td class='font-italic'>";
//                                      echo ucwords($au['full_name']);
//                                    echo  "</td>";
//                                    echo  "<td>";
//                                        echo strtolower($au['email']);
//                                    echo  "</td>";
//
//                                    echo  "<td class=$color_text>";
//                                        echo strtoupper($au['role']);
//                                    echo  "</td>";
//
//                                    echo  "<td>";
//                                        echo $formatted_date . " | " . $formatted_time;
//                                    echo  "</td>";
//                                    echo  "<td style='display: none;'>";
//                                        echo ucwords($au['uid']);
//                                    echo  "</td>";
//
//                                }
//                               ?>
    <!--                               --><?php
//                               foreach ($all_users as $au){
////
//                                   $color_text = 'col-red';
//                                   if($au['role'] == 'Administrator')
//                                       $color_text = 'col-red';
//                                   elseif($au['role'] == 'Manager')
//                                       $color_text = 'col-blue';
//                                   elseif($au['role'] == 'Employee')
//                                       $color_text = 'col-orange';
//                                   else
//                                       $color_text = 'col-green';
//
//                                   $d = new DateTime($au['created_at']);
//                                   $formatted_date = $d->format('M, d Y'); // 05-Sep-2018
//                                   $formatted_time = $d->format('h:i A'); // 11:18 AM
//
//                                   echo "<tr class='font-14' data-toggle='tooltip' data-placement='bottom' title='2. To Upload To Server'>";
//
//                                   echo  "<td class='font-italic'>";
//                                   echo ucwords($au['full_name']);
//                                   echo  "</td>";
//                                   echo  "<td>";
//                                   echo strtolower($au['email']);
//                                   echo  "</td>";
//
//                                   echo  "<td class=$color_text>";
//                                   echo strtoupper($au['role']);
//                                   echo  "</td>";
//
//                                   echo  "<td>";
//                                   echo $formatted_date . " | " . $formatted_time;
//                                   echo  "</td>";
//                                   echo  "<td style='display: none;'>";
//                                   echo ucwords($au['uid']);
//                                   echo  "</td>";
//
//                               }
////                               ?>