<?php

class Color extends DB_object
{
    protected static $db_table="colors";
    protected static $db_table_fields=array('color_name','color_code','status');
    public $id;
    public $color_name;
    public $color_code;
    public $status;

    public static function find_color($code)
    {
        global $database;
        $the_result_array= self::find_this_query("SELECT * FROM ".static::$db_table." WHERE color_code='$code' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }
    
}

