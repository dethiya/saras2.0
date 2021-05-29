<?php


class PDI_History extends Db_object
{
    protected static $db_table="pdi_history";
    protected static $db_table_fields=array('vehicle_id','user_name','stock_loc_id','stock_status','updated_at');

    public $id;
    public $vehicle_id;
    public $user_name;
    public $stock_loc_id;
    public $updated_at;
    public $stock_status;
}