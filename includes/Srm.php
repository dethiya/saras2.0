<?php

class Srm extends DB_object
{
    protected static $db_table="srms";
    protected static $db_table_fields=array('srm_name','outlet_id','status');
    public $id;
    public $srm_name;
    public $outlet_id;
    public $status;

    public static function find_srm($code)
    {
        global $database;
        $the_result_array= self::find_this_query("SELECT * FROM ".static::$db_table." WHERE id='$code' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }
}

