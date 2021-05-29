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

$fpr_total=$ngp_fpr+$nsk_fpr+$nnd_fpr+$dhl_fpr+$ngp_nx_fpr+$nsk_nx_fpr+$nnd_nx_fpr+$ngp_com_fpr+$nsk_com_fpr+$nnd_com_fpr+$dhl_com_fpr;
$allot_total=$ngp_allot+$nsk_allot+$nnd_allot+$dhl_allot+$ngp_nx_allot+$nsk_nx_allot+$nnd_nx_allot+$ngp_com_allot+$nsk_com_allot+$nnd_com_allot+$dhl_com_allot;
$bt_total=$ngp_bt+$nsk_bt+$nnd_bt+$dhl_bt+$ngp_nx_bt+$nsk_nx_bt+$nnd_nx_bt+$ngp_com_bt+$nsk_com_bt+$nnd_com_bt+$dhl_com_bt;
$free_total=$ngp_free+$nsk_free+$nnd_free+$dhl_free+$ngp_nx_free+$nsk_nx_free+$nnd_nx_free+$ngp_com_free+$nsk_com_free+$nnd_com_free+$dhl_com_free;
$arena_total=$fpr_total+$allot_total+$bt_total+$free_total;

$dataJson='{
    "data": [
    [
        "A",
        "NSK",
        "'.$nsk_fpr.'",
        "'.$nsk_allot.'",
        "'.$nsk_bt.'",
        "'.$nsk_free.'",
        "'.$nsk_total.'"
    ],
    [
        "B",
        "NGP",
        "'.$ngp_fpr.'",
        "'.$ngp_allot.'",
        "'.$ngp_bt.'",
        "'.$ngp_free.'",
        "'.$ngp_total.'"
    ],
    [
        "C",
        "NND",
        "'.$nnd_fpr.'",
        "'.$nnd_allot.'",
        "'.$nnd_bt.'",
        "'.$nnd_free.'",
        "'.$nnd_total.'"
    ],
    [
        "D",
        "DHL",
        "'.$dhl_fpr.'",
        "'.$dhl_allot.'",
        "'.$dhl_bt.'",
        "'.$dhl_free.'",
        "'.$dhl_total.'"
    ],
       [
        "E",
        "NGP-NEXA",
        "'.$nsk_nx_fpr.'",
        "'.$nsk_nx_allot.'",
        "'.$nsk_nx_bt.'",
        "'.$nsk_nx_free.'",
        "'.$nsk_nx_total.'"
    ],
    [
        "F",
        "NGP-NEXA",
        "'.$ngp_nx_fpr.'",
        "'.$ngp_nx_allot.'",
        "'.$ngp_nx_bt.'",
        "'.$ngp_nx_free.'",
        "'.$ngp_nx_total.'"
    ],
    [
        "G",
        "NND-NEXA",
        "'.$nnd_nx_fpr.'",
        "'.$nnd_nx_allot.'",
        "'.$nnd_nx_bt.'",
        "'.$nnd_nx_free.'",
        "'.$nnd_nx_total.'"
    ],
    [
        "H",
        "NSK-COMM",
        "'.$nsk_com_fpr.'",
        "'.$nsk_com_allot.'",
        "'.$nsk_com_bt.'",
        "'.$nsk_com_free.'",
        "'.$nsk_com_total.'"
    ],
    [
        "I",
        "NGP-COMM",
        "'.$ngp_com_fpr.'",
        "'.$ngp_com_allot.'",
        "'.$ngp_com_bt.'",
        "'.$ngp_com_free.'",
        "'.$ngp_com_total.'"
    ],
    [
        "J",
        "NND-COMM",
        "'.$nnd_com_fpr.'",
        "'.$nnd_com_allot.'",
        "'.$nnd_com_bt.'",
        "'.$nnd_com_free.'",
        "'.$nnd_com_total.'"
    ],
    [
        "K",
        "DHL-COMM",
        "'.$dhl_com_fpr.'",
        "'.$dhl_com_allot.'",
        "'.$dhl_com_bt.'",
        "'.$dhl_com_free.'",
        "'.$dhl_com_total.'"
    ],
    [
        "Total",
        "",
        "'.$fpr_total.'",
        "'.$allot_total.'",
        "'.$bt_total.'",
        "'.$free_total.'",
        "'.$arena_total.'"
    ]
    
]
}';
echo $dataJson;