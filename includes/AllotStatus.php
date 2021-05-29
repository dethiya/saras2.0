<?php


class AllotStatus extends Db_object
{
    protected static $db_table='allot_status';
    protected static $db_table_fields=array('status','is_available');

    public $id;
    public $status;
    public $is_available;

}