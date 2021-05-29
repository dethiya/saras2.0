<?php


class ExchangeHistory extends Db_object
{
    protected static $db_table="exchange_history";
    protected static $db_table_fields=array(
        'vehicle_id',
        'allotment_dt',
        'customer_name',
        'is_exchange',
        'exch_status',
        'exch_date',
        'exch_remark',
        'updated_by',
        'updated_at'
    );

    public $id;
    public $vehicle_id;
    public $allotment_dt;
    public $customer_name;
    public $is_exchange;
    public $exch_status;
    public $exch_date;
    public $exch_remark;
    public $updated_by;
    public $updated_at;
}