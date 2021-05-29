<?php


class Indent extends Db_object
{
    protected static $db_table="indents";
    protected static $db_table_fields=array('vehicle_id','request_user_id','request_outlet_id','datetime','is_approved','approved_by','approval_datetime','existing_outlet_code','dispatch','dispatch_date','received_by','receipt_date');

    public $id;
    public $vehicle_id;
    public $request_user_id;
    public $request_outlet_id;
    public $datetime;
    public $is_approved;
    public $approved_by;
    public $approval_datetime;
    public $existing_outlet_code;
    public $dispatch;
    public $dispatch_date;
    public $receipt_date;
    public $received_by;
}