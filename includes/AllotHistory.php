<?php


class AllotHistory extends Db_object
{
    protected static $db_table="allotment_history";
    protected static $db_table_fields=array('vehicle_id','allot_status_id','allotment_dt','customer_name','srm_id','rm_id','remarks','updated_by','updated_at');

    public $id;
    public $vehicle_id;
    public $allot_status_id;
    public $allotment_dt;
    public $customer_name;
    public $srm_id;
    public $rm_id;
    public $remarks;
    public $updated_by;
    public $updated_at;
}