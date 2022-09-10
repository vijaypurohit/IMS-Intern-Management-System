<?php
/**
 * Created by PhpStorm.
 * User: Vijay Purohit
 * Date: 26-Jun-19
 * Time: 1:28 PM
 * Project: ims_vj
 */

$asset_path_link='../';
$adm_pages_link='';

$jqueryDataTable=1;
?>

<?php  require_once($asset_path_link.'config.php'); ?>
<?php  require_once (ADM_PATH .'/_.php'); ?>
<?php  require_once('batch_logics.php'); ?>

<?php
if(isset($_REQUEST['bid'])){
    $batch_id = $_REQUEST['bid'];
}

$batch = getBatch($batch_id);
$batch_interns = getUserRoleProfileOfInternsInBatch($batch_id);
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="com bo"
                style="text-align: center; font-size: 20px; letter-spacing: 2px; padding-bottom: 5px;">
                BATCH
            </h2>
        </div>
        <?php  include(INCLUDE_PATH . '/layouts/_messages.php'); ?>
        <!-- FIRST ROW -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card" >
                    <div class="header" style="background: aliceblue">
                        <h2 style="text-align: center; color: darkblue; font-weight: bold ">
                            <?php echo $batch['batch_name']." (".$batch['batch_year'].") "; ?>
                        </h2>
                    </div>
                    <div class="body" >
                           <div class="row clearfix">
                               <div class="col-md-12">
                                   <div class="col-xs-12 col-sm-6 col-md-6" ">
                                       <div class="form-group">
                                           <label>  CREATED AT :  </label>
                                           <?php
                                           $d = new DateTime($batch['created_at']);
                                           $formatted_date = $d->format('M, d Y');
                                           $formatted_time = $d->format('h:i A');
                                           echo $formatted_date . " | " . $formatted_time;
                                           ?>
                                       </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-6 col-md-6">
                                       <div class="form-group">
                                           <label>CREATED BY   :  </label>
                                           <?php echo $batch['created_by_name']; ?>
                                       </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-6 col-md-6">
                                       <div class="form-group">
                                           <label>   FROM  :  </label>
                                           <?php
                                           $df = new DateTime($batch['from_d_b']);
                                           $formatted_date_f = $df->format('M, d Y');
                                           $formatted_date_f_normal = $df->format('d-m-Y');
                                           echo $formatted_date_f_normal ;
                                           ?>
                                       </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-6 col-md-6">
                                       <div class="form-group">
                                           <label>   TO  :  </label>
                                           <?php
                                           $dt = new DateTime($batch['to_d_b']);
                                           $formatted_date_t = $dt->format('M, d Y');
                                           $formatted_date_t_normal = $dt->format('d-m-Y');
                                           $interval = $df->diff($dt);
                                           $noOfD =  $interval->format('%m months, %R%d days');
                                           echo $formatted_date_t_normal ;
                                           ?>
                                       </div>
                                   </div>
                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <label>DURATION   :  </label>
                                           <?php echo $formatted_date_f." - ".$formatted_date_t." (".$noOfD.")"; ?>
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-6 col-md-6">
                                       <div class="form-group">
                                           <label>   NUM OF MEMBERS :  </label>
                                           <?php echo $batch['number_of_interns']; ?>
                                       </div>
                                   </div>
                               </div>
                           </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" >
                <div class="card " >
                    <div class="header" style="background: lightsalmon">
                        <h2 >
                            MEMBERS
                        </h2>
                    </div>
                    <div class="body" style="overflow-y: scroll; height: 340px">
                        <div class="row clearfix">
                            <div class="col-md-12" >
                                <table class="table-bordered" width="100%" style="padding-top: 20px; line-height: 30px; letter-spacing: 0.1px; font-size: 14px; ">
                                    <thead>
                                    <tr>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    foreach ($batch_interns as $bi ) {
                                        echo "<tr>";
                                        ?>
                                        <td>
                                            <a class="identifyingClass" data-toggle="modal" data-target="#loginModal" data-profile_picture="<?php echo $bi['profile_picture'] ?>"  data-id="<?php echo $bi['uid'] ?>" style="letter-spacing: 2px; color: olive; font-weight: bold" >
                                                <?php echo  strtoupper($bi['full_name']) ?> </a>
                                        </td>
                                        <?php
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END FIRST ROW -->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header" style="background: #ec3e0e">
                        <h2 style="color: ghostwhite; text-align: center">
                            ALL TEAMS
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
                            <table  class="table table-bordered table-striped table-hover dataTable team-list-batch">
                                <thead>
                                <tr style="font-weight: bold; background: #607d8b; color: white">
                                    <th>TEAM NAME</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of members" >#M</th>
                                    <th data-toggle="tooltip" data-placement="top" title="number of projects" >#P</th>
                                    <th>CREATED AT</th>
                                    <th>CREATED BY</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr style="font-weight: bold; background: #607d8b; color: white; table-layout: fixed">
                                    <th>TEAM NAME</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of members">#M</th>
                                    <th data-toggle="tooltip" data-placement="bottom" title="number of projects">#P</th>
                                    <th>CREATED AT</th>
                                    <th>CREATED BY</th>
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
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-body">
                    <img src="" id="profile_pic_img_tag" alt="a" height="100%" width="100%">
<!--                    <input type="text" name="bookId" id="hiddenValue" value=""/>-->
                </div>
                <!--modal body-->
                <div class="modal-footer">
                    <a href="" id="uid_a_href_tag" target="_blank">
                    <button type="button" data-color="blue" class="btn btn-link waves-effect" >VIEW</button></a>
                    <button type="button" data-color="black" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
        </div>
        <!--modal content-->
    </div>
    <!--        modal dialog-->
</div>
<!-- ----------------------------------------- END HTML BODY ------------------------------------------------------------ -->

<!-- ----------------------------------------- HTML FOOTER --------------------------------------------------------------- -->
<?php require_once (INCLUDE_PATH .'/layouts/_footer.php'); ?>
<!-- Custom Js -->
<!-- Demo Js for skin color etc-->
<!--<script src="--><?php //echo $asset_path_link ?><!--assets/bsb/js/demo.js"></script>-->
<!-- CUSTOM SETTINGS DATETIME Js -->
<script type="text/javascript">

    $(function () {
        $(".identifyingClass").click(function () {
            var profile_picture = $(this).data('profile_picture');
            var uid = $(this).data('id');
            var profile_to_show = "<?php echo UPLOAD_URL.$upload_profile_fol_name ?>"+profile_picture;
            var url_to_show = "<?php echo $adm_pages_link?>users/user_profile_view.php?uid="+uid;
            // $(".modal-body #hiddenValue").val(profile_to_show);
            document.getElementById("profile_pic_img_tag").alt=profile_picture;
            document.getElementById("profile_pic_img_tag").src=profile_to_show;
            document.getElementById("uid_a_href_tag").href=url_to_show;
        })
    });

    $(function () {
        var table =  $('.team-list-batch').DataTable({
            ajax: "batch_logics.php?&dtShowAllTeamsBatch="+"team_lists_batch&batch_id=" + <?php echo $batch_id?>,
            columns: [
                { "data": "team_name" },
                { "data": "num_members" },
                { "data": "num_projects" },
                { "data": "created_at" },
                { "data": "created_by_name_team" }
            ],
            deferRender: true,
            scrollY   : '60vh',                    // vertical port view
            responsive: true,
            scrollCollapse: true,                // cause DataTables to collapse the table's viewport when the result set fits within the given Y height.
            order: [[2, 'asc'],[0, 'asc']],
            // rowGroup: {
            //     dataSrc: 'batch_name'                 // row grouping based on column
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
                        $(win.document.body).find('h1').text('<?php echo APP_TITLE ?> - Teams');
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
        $('.team-list-batch tbody').on('click', 'tr', function () {
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