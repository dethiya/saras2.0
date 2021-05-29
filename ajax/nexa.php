<?php
$page_title='Stock Summary';
include '../includes/init.php';
if (!$session->is_signed_in()) {redirect("login.php");}

$session_user = User::find($session->user_id);
//Nashik
$nsk_fpr=Stock::local_allotments('3701',1);
$nsk_allot=Stock::local_allotments('3701',2);
$nsk_bt=Stock::local_allotments('3701',3);
$nsk_free=Stock::local_allotments('3701',4);
$nsk_total=$nsk_fpr+$nsk_free+$nsk_allot+$nsk_bt;

$nsk_nx_fpr=Stock::local_allotments('37NA',1);
$nsk_nx_allot=Stock::local_allotments('37NA',2);
$nsk_nx_bt=Stock::local_allotments('37NA',3);
$nsk_nx_free=Stock::local_allotments('37NA',4);
$nsk_nx_total=$nsk_nx_fpr+$nsk_nx_free+$nsk_nx_allot+$nsk_nx_bt;

$nsk_com_fpr=Stock::local_allotments('37CB',1);
$nsk_com_allot=Stock::local_allotments('37CB',2);
$nsk_com_bt=Stock::local_allotments('37CB',3);
$nsk_com_free=Stock::local_allotments('37CB',4);
$nsk_com_total=$nsk_com_fpr+$nsk_com_free+$nsk_com_allot+$nsk_com_bt;

//Nagpur
$ngp_fpr=Stock::local_allotments('2002',1);
$ngp_allot=Stock::local_allotments('2002',2);
$ngp_bt=Stock::local_allotments('2002',3);
$ngp_free=Stock::local_allotments('2002',4);
$ngp_total=$ngp_fpr+$ngp_free+$ngp_allot+$ngp_bt;

$ngp_nx_fpr=Stock::local_allotments('20NB',1);
$ngp_nx_allot=Stock::local_allotments('20NB',2);
$ngp_nx_bt=Stock::local_allotments('20NB',3);
$ngp_nx_free=Stock::local_allotments('20NB',4);
$ngp_nx_total=$ngp_nx_fpr+$ngp_nx_free+$ngp_nx_allot+$ngp_nx_bt;

$ngp_com_fpr=Stock::local_allotments('20CC',1);
$ngp_com_allot=Stock::local_allotments('20CC',2);
$ngp_com_bt=Stock::local_allotments('20CC',3);
$ngp_com_free=Stock::local_allotments('20CC',4);
$ngp_com_total=$ngp_com_fpr+$ngp_com_free+$ngp_com_allot+$ngp_com_bt;

//Nanded
$nnd_fpr=Stock::local_allotments('6801',1);
$nnd_allot=Stock::local_allotments('6801',2);
$nnd_bt=Stock::local_allotments('6801',3);
$nnd_free=Stock::local_allotments('6801',4);
$nnd_total=$nnd_fpr+$nnd_free+$nnd_allot+$nnd_bt;

$nnd_nx_fpr=Stock::local_allotments('68NA',1);
$nnd_nx_allot=Stock::local_allotments('68NA',2);
$nnd_nx_bt=Stock::local_allotments('68NA',3);
$nnd_nx_free=Stock::local_allotments('68NA',4);
$nnd_nx_total=$nnd_nx_fpr+$nnd_nx_free+$nnd_nx_allot+$nnd_nx_bt;

$nnd_com_fpr=Stock::local_allotments('68CA',1);
$nnd_com_allot=Stock::local_allotments('68CA',2);
$nnd_com_bt=Stock::local_allotments('68CA',3);
$nnd_com_free=Stock::local_allotments('68CA',4);
$nnd_com_total=$nnd_com_fpr+$nnd_com_free+$nnd_com_allot+$nnd_com_bt;

$dhl_fpr=Stock::local_allotments('P301',1);
$dhl_allot=Stock::local_allotments('P301',2);
$dhl_bt=Stock::local_allotments('P301',3);
$dhl_free=Stock::local_allotments('P301',4);
$dhl_total=$dhl_fpr+$dhl_free+$dhl_allot+$dhl_bt;

$dhl_com_fpr=Stock::local_allotments('P3CA',1);
$dhl_com_allot=Stock::local_allotments('P3CA',2);
$dhl_com_bt=Stock::local_allotments('P3CA',3);
$dhl_com_free=Stock::local_allotments('P3CA',4);
$dhl_com_total=$dhl_com_fpr+$dhl_com_free+$dhl_com_allot+$dhl_com_bt;

$fpr_total=$ngp_fpr+$nsk_fpr+$nnd_fpr+$dhl_fpr;
$nx_fpr=$ngp_nx_fpr+$nsk_nx_fpr+$nnd_nx_fpr;
$com_fpr=$ngp_com_fpr+$nsk_com_fpr+$nnd_com_fpr+$dhl_com_fpr;

$allot_total=$ngp_allot+$nsk_allot+$nnd_allot+$dhl_allot;
$nx_allot=$ngp_nx_allot+$nsk_nx_allot+$nnd_nx_allot;
$com_allot=$ngp_com_allot+$nsk_com_allot+$nnd_com_allot+$dhl_com_allot;

$bt_total=$ngp_bt+$nsk_bt+$nnd_bt+$dhl_bt;
$nx_bt=$ngp_nx_bt+$nsk_nx_bt+$nnd_nx_bt;
$com_bt=$ngp_com_bt+$nsk_com_bt+$nnd_com_bt+$dhl_com_bt;

$free_total=$ngp_free+$nsk_free+$nnd_free+$dhl_free;
$nx_free=$ngp_nx_free+$nsk_nx_free+$nnd_nx_free;
$com_free=$ngp_com_free+$nsk_com_free+$nnd_com_free+$dhl_com_free;

$arena_total=$fpr_total+$allot_total+$bt_total+$free_total;
$nx_total=$nx_fpr+$nx_allot+$nx_bt+$nx_free;
$com_total=$com_fpr+$com_allot+$com_bt+$com_free;
?>
<!--ARENA-->
<tr>
    <td>1</td>
    <td>Nashik</td>
    <td><?=$nsk_fpr?></td>
    <td><?=$nsk_allot?></td>
    <td><?=$nsk_bt?></td>
    <td><?=$nsk_free?></td>
    <td><?=$nsk_total?></td>
</tr>
<tr>
    <td>2</td>
    <td>Nagpur</td>
    <td><?=$ngp_fpr?></td>
    <td><?=$ngp_allot?></td>
    <td><?=$ngp_bt?></td>
    <td><?=$ngp_free?></td>
    <td><?=$ngp_total?></td>
</tr>
<tr>
    <td>3</td>
    <td>Nanded</td>
    <td><?=$nnd_fpr?></td>
    <td><?=$nnd_allot?></td>
    <td><?=$nnd_bt?></td>
    <td><?=$nnd_free?></td>
    <td><?=$nnd_total?></td>
</tr>
<tr>
    <td>4</td>
    <td>Dhule</td>
    <td><?=$dhl_fpr?></td>
    <td><?=$dhl_allot?></td>
    <td><?=$dhl_bt?></td>
    <td><?=$dhl_free?></td>
    <td><?=$dhl_total?></td>
</tr>
<tr class="bg-secondary-transparent-2">
    <th></th>
    <th>ARENA Total</th>
    <th><?=$fpr_total?></th>
    <th><?=$allot_total?></th>
    <th><?=$bt_total?></th>
    <th><?=$free_total?></th>
    <th><?=$arena_total?></th>
</tr>

<!--NEXA-->
<tr>
    <td>1</td>
    <td>NEXA - Nashik</td>
    <td><?=$nsk_nx_fpr?></td>
    <td><?=$nsk_nx_allot?></td>
    <td><?=$nsk_nx_bt?></td>
    <td><?=$nsk_nx_free?></td>
    <td><?=$nsk_nx_total?></td>
</tr>
<tr>
    <td>2</td>
    <td>NEXA - Nagpur</td>
    <td><?=$ngp_nx_fpr?></td>
    <td><?=$ngp_nx_allot?></td>
    <td><?=$ngp_nx_bt?></td>
    <td><?=$ngp_nx_free?></td>
    <td><?=$ngp_nx_total?></td>
</tr>
<tr>
    <td>3</td>
    <td>NEXA - Nanded</td>
    <td><?=$nnd_nx_fpr?></td>
    <td><?=$nnd_nx_allot?></td>
    <td><?=$nnd_nx_bt?></td>
    <td><?=$nnd_nx_free?></td>
    <td><?=$nnd_nx_total?></td>
</tr>
<tr class="bg-secondary-transparent-2">
    <th></th>
    <th>NEXA Total</th>
    <th><?=$nx_fpr?></th>
    <th><?=$nx_allot?></th>
    <th><?=$nx_bt?></th>
    <th><?=$nx_free?></th>
    <th><?=$nx_total?></th>
</tr>
<tr >
    <td>1</td>
    <td>Commercial - Nashik</td>
    <td><?=$nsk_com_fpr?></td>
    <td><?=$nsk_com_allot?></td>
    <td><?=$nsk_com_bt?></td>
    <td><?=$nsk_com_free?></td>
    <td><?=$nsk_com_total?></td>
</tr>
<tr>
    <td>2</td>
    <td>Commercial - Nagpur</td>
    <td><?=$ngp_com_fpr?></td>
    <td><?=$ngp_com_allot?></td>
    <td><?=$ngp_com_bt?></td>
    <td><?=$ngp_com_free?></td>
    <td><?=$ngp_com_total?></td>
</tr>
<tr>
    <td>3</td>
    <td>Commercial - Nanded</td>
    <td><?=$nnd_com_fpr?></td>
    <td><?=$nnd_com_allot?></td>
    <td><?=$nnd_com_bt?></td>
    <td><?=$nnd_com_free?></td>
    <td><?=$nnd_com_total?></td>
</tr>
<tr>
    <td>4</td>
    <td>Commercial - Nagpur</td>
    <td><?=$dhl_com_fpr?></td>
    <td><?=$dhl_com_allot?></td>
    <td><?=$dhl_com_bt?></td>
    <td><?=$dhl_com_free?></td>
    <td><?=$dhl_com_total?></td>
</tr>
<tr class="bg-secondary-transparent-2">
    <th></th>
    <th>COMMERCIAL Total</th>
    <th><?=$com_fpr?></th>
    <th><?=$com_allot?></th>
    <th><?=$com_bt?></th>
    <th><?=$com_free?></th>
    <th><?=$com_total?></th>
</tr>