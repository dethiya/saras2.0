<?php
$page_title='Stock Summary';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$sql='SELECT outlets.outlet_name, channels.channel_name, ';
$sql.=' COUNT(CASE WHEN dispatches.allot_status_id = "1" THEN dispatches.allot_status_id END) "FRP",';
$sql.=' COUNT(CASE WHEN dispatches.allot_status_id = "2" THEN dispatches.allot_status_id END) "Allot",';
$sql.=' COUNT(CASE WHEN dispatches.allot_status_id = "3" THEN dispatches.allot_status_id END) "BT",';
$sql.=' COUNT(CASE WHEN dispatches.allot_status_id = "4" THEN dispatches.allot_status_id END) "Free"';
$sql.=' FROM dispatches, outlets, channels';
$sql.=' WHERE outlets.outlet_code=dispatches.delr and outlets.channel_id=channels.id and channels.id=2';
$sql.=' GROUP BY channels.channel_name, dispatches.delr';
$sql.=' ORDER BY channels.channel_name, dispatches.delr';


/*
 *
 * SELECT outlets.outlet_name, channels.channel_name,
COUNT(CASE WHEN dispatches.allot_status_id = "1" THEN dispatches.allot_status_id END) "FRP",
COUNT(CASE WHEN dispatches.allot_status_id = "2" THEN dispatches.allot_status_id END) "Allot",
COUNT(CASE WHEN dispatches.allot_status_id = "3" THEN dispatches.allot_status_id END) "BT",
COUNT(CASE WHEN dispatches.allot_status_id = "4" THEN dispatches.allot_status_id END) "Free"
FROM dispatches, outlets, channels
WHERE outlets.outlet_code=dispatches.delr and outlets.channel_id=channels.id
GROUP BY channels.channel_name, dispatches.delr
ORDER BY channels.channel_name, dispatches.delr
 *
 */





$result=$database->query($sql);
$i=1;
$total_fpr=$total_allot=$total_bt=$total_free=0;

while($row=mysqli_fetch_row($result)){

    $row_total=$row[2]+$row[3]+$row[4]+$row[5];
    echo '
<tr>

<td>'.$i.'</td>
<td>'.$row[0].'</td>
    <td class="text-sm-center">'.$row[2].' <br><span class="badge badge-gray">'.number_format(($row[2]/$row_total)*100,2).'% </span></td>
<td class="text-sm-center">'.$row[3].' <br><span class="badge badge-danger">'.number_format(($row[3]/$row_total)*100,2).'% </span></td>
<td class="text-sm-center">'.$row[4].' <br><span class="badge badge-orange">'.number_format(($row[4]/$row_total)*100,2).'% </span></td>
<td class="text-sm-center">'.$row[5].' <br><span class="badge badge-blue">'.number_format(($row[5]/$row_total)*100,2).'% </span></td>

<th class="text-sm-center">'.$row_total.'</th>
';


    $total_fpr+=$row[2];
    $total_allot+=$row[3];
    $total_bt+=$row[4];
    $total_free+=$row[5];
    $i++;
}
$total_stock=$total_fpr+$total_allot+$total_bt+$total_free;
echo '
<tfoot>
      <tr >
            <th colspan="2">Total</th>
            <th class="text-center">'.$total_fpr.'<br><span class="badge badge-gray">'.number_format(($total_fpr/$total_stock)*100,2).'% </span></th>
            <th class="text-center">'.$total_allot.'<br><span class="badge badge-danger">'.number_format(($total_allot/$total_stock)*100,2).'% </span></th>
            <th class="text-center">'.$total_bt.'<br><span class="badge badge-orange">'.number_format(($total_bt/$total_stock)*100,2).'% </span></th>
            <th class="text-center">'.$total_free.'<br><span class="badge badge-blue">'.number_format(($total_free/$total_stock)*100,2).'% </span></th>
            <th class="text-center">'.$total_stock.'</th>
      </tr>
</tfoot>   

';

