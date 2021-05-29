<?php

class Outlet extends DB_object
{
    protected static $db_table="outlets";
    protected static $db_table_fields=array('channel_id','outlet_name','outlet_code','status');
    public $id;
    public $channel_id;
    public $outlet_name;
    public $outlet_code;
    public $status;

    public static function find_outlet($code)
    {
        global $database;
        $the_result_array= self::find_this_query("SELECT * FROM ".static::$db_table." WHERE outlet_code='$code' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }

}

