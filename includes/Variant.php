<?php

class Variant extends DB_object
{
    protected static $db_table="variants";
    protected static $db_table_fields=array('model_id','variant_name','variant_code','transmission','status');
    public $id;
    public $model_id;
    public $variant_name;
    public $variant_code;
    public $transmission;
    public $status;

    public static function find_variant($code)
    {
        global $database;
        $the_result_array= self::find_this_query("SELECT * FROM ".static::$db_table." WHERE variant_code='$code' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }

}

