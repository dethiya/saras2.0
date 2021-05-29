<?php


class DeliveryDatabase extends Db_object
{
    protected static $db_table="delivery_customers";
    protected static $db_table_fields=array(
        'vehicle_id',
        'gatepass',
        'mobile_no',
        'date_of_birth',
        'email_id',
        'address',
        'updated_by',
        'updated_at'
    );

    public $id;
    public $vehicle_id;
    public $gatepass;
    public $mobile_no;
    public $date_of_birth;
    public $email_id;
    public $address;
    public $updated_by;
    public $updated_at;

    public static function find_customer($vehicle_id)
    {
        global $database;
        $the_result_array= self::find_this_query("SELECT * FROM ".static::$db_table." WHERE vehicle_id='$vehicle_id' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }

}