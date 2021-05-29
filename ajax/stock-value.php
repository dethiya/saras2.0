<?php
$page_title='Stock Summary';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$sql='SELECT variants.model_id,  COUNT(dispatches.model_code), SUM(dispatches.invoice_amt_rs)';
$sql.=' FROM dispatches, variants';
$sql.=' WHERE allot_status_id in (1,2,3,4) and variants.variant_code=dispatches.model_code';
$sql.=' GROUP BY variants.model_id';
$sql.=' ORDER BY SUM(dispatches.invoice_amt_rs) DESC';

$result=$database->query($sql);
$i=1;
$count_total=$sum_total=0;
while($row=mysqli_fetch_row($result)){
    $sum=$row[2];
    $model_id=$row[0];
    $name=Model::find($model_id);
    $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sum);

    echo '
<tr>

<td>'.$i.'</td>
<td>'.$name->model_name.'</td>
<td class="text-center">'.$row[1].'</td>
<td class="text-right">'.$num.'</td>
';

    $count_total+=$row[1];
    $sum_total+=$row[2];
    $curr_total = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $sum_total);
    $i++;
}
?>
<tfoot>

<tr>
    <th colspan="2">Total</th>
    <th class="text-center"><?=$count_total?></th>
    <th class="text-right"><?=$curr_total?></th>
</tr>

</tfoot>