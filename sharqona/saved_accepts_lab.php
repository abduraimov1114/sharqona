<?php session_start(); ?>
<?php ob_start(); ?>
<?php require_once '../includes/db.php'; ?>
<?php require_once '../includes/dollar.php';
include_once("../DB/functions.php");
$func = new database_func();
?>
<?php
if ( !isset($_SESSION['ses_user_id']) || !isset($_SESSION['ses_user_name']) || !isset($_SESSION['ses_user_role'])) {
    die("<h1 align='center'>Let's get out of here!</h1>");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Compass Group Admin Panel" />
    <link rel="icon" href="assets/images/favicon.ico">
    <title>Saqlangan ishlar Laboratoriya</title>
    <!-- Bu yerda scriptlar -->
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/neon-core.css">
    <link rel="stylesheet" href="assets/css/neon-theme.css">
    <link rel="stylesheet" href="assets/css/neon-forms.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <!-- Bu yerda scriptlar -->
</head>
<body class="page-body">
<div class="page-container">

    <?php require_once 'addincludes/sidebar.php'; ?>
    <?php require_once 'addincludes/userinfo.php'; ?>

    <!-- Shu yerdan asosiy conternt -->
    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var $table1 = jQuery( '#table-1' );

            // Initialize DataTable
            $table1.DataTable( {
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "bStateSave": true
            });

            // Initalize Select Dropdown after DataTables is created
            $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
                minimumResultsForSearch: -1
            });
        } );
    </script>
    <table class="table prices" id="table-1">
        <h3 style="text-align: center;">Saqlangan ishlar (Laboratoriya)</h3>
        <thead>
        <tr class="replace-inputs">
            <th>Date</th>
            <th>Table</th>
            <th>Buyer</th>
            <th>Information</th>
            <th>Buyer name</th>
            <th>Buyer phone</th>
            <th>Master</th>
            <th width="12%">Edit</th>
        </tr>
        </thead>
        <?
//        ustolar nomi
        $numUser=0;
        $user[$numUser]=0;
        $sorov0 ="select * from users WHERE NOT user_id=1";
        $func->queryMysql($sorov0);
        while($row=$func->result->fetch_array(MYSQL_ASSOC)){
            $id=$row['user_id'];
            $user[$id]=$row['user_name'];
        }
//        usto end
            $sorov="select count(sd_id) from saved_datails";
            $func->queryMysql($sorov);
            $row=$func->result->fetch_array(MYSQL_ASSOC);
//        length
            $length=$row['count(sd_id)'];
//        saved id from saved_datails
        $sorov="select DISTINCT saved_id from saved_datails";
        $func->queryMysql($sorov);
        $count=0;
        $saved_id[$count];
        $saved_sum[$count]=0;
        while($row=$func->result->fetch_array(MYSQL_ASSOC)){
            $saved_id[$count]=$row['saved_id'];
            $count++;
        }
//        echo "<br/>".$saved_id[3]."<br/>";
        for($i=0;$i<$count;$i++){
            $sorov="select * from saved_datails WHERE saved_id=".$saved_id[$i];
            $func->queryMysql($sorov);
            while($row=$func->result->fetch_array(MYSQL_ASSOC)){
                $saved_sum[$i]+=$row['one_price']*$row['count'];
            }
        }
        ?>
        <tbody>
        <?
            $sorov="select * from saved INNER JOIN buyers ON saved.buyer_id=buyers.buyers_id WHERE saved.storage_id=3 ORDER BY saved.saved_id DESC";
            $func->queryMysql($sorov);
            $count1=$count;
            $soni = 0;
            while($row=$func->result->fetch_array(MYSQL_ASSOC)){
                $count1--;
                $description = $row['saved_desc'];

        ?>
            <tr class="odd gradeX">
                <td class="text-center"><? echo $row['data']; ?></td>
                <?
                    if($row['saved_times']==1){
                ?>
                    <td class="text-center"><? echo $row['buyer_id']; ?></td>
                <?}else{?>
                    <td class="text-center"><? echo $row['buyer_id']."-".($row['saved_times']); ?></td>
                <?}?>
                <td class="text-center"><? echo $row['buyers_name']; ?></td>
                <td class="text-center"><? echo substr($description,0,40); ?></td>
                <td class="text-center"><? echo $row['user_name']; ?></td>
                <td class="text-center"><? echo $row['tell_num']; ?></td>
                <td class="text-center"><?
                    $usto = $row['usto_id'];
                    echo $user[$usto];
                    ?></td>

                <td class="text-center">
                    <?
                        if($row['buyer_id']!=10){
                        ?>
                            <a href="update_accept.php?update=<? echo $row['saved_id']; ?>&storage=3" class="btn btn-info"><i class="entypo-info"></i></a>
                        <?
                    }
                    else{
                        ?>
                            <a href="update_accept_street.php?update=<? echo $row['saved_id']; ?>&storage=3" class="btn btn-info"><i class="entypo-info"></i></a>
                        <?}?>
                    <a href="dell_save.php?dell=<? echo $row['saved_id']; ?>&storage=3" class="btn btn-danger" onClick="deleteqilish(this);return false;"><i class="entypo-trash"></i></a>
                </td>
            </tr>
            <?php $soni++ ?>
        <?
            }?>
        </tbody>
        <h3 class="text-center text-danger">Jami saqlangan ishlar soni: <?php echo $soni; ?></h3><br>
    </table><br>
</div>
</div>
<script>
    function deleteqilish(f) {
    if (confirm("Kiritilgan ma'lumotlarni yana bir bora tekshirib chiqing.\nXato yo'qligiga aminmisiz?")) 
       f.submit();
    }
</script>
<!-- /Footercha -->
<!-- Bu yerda xam skriptlar -->
<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/bootstrap-tagsinput.min.js"></script>
<script src="assets/js/typeahead.min.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/daterangepicker/daterangepicker.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/icheck/icheck.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

<!-- /Bu yerda xam skriptlar -->
</body>
</html>