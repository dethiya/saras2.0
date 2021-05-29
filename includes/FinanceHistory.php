<?php


class FinanceHistory extends Db_object
{
    protected static $db_table="finance_history";
    protected static $db_table_fields=array(
        'vehicle_id',
        'allotment_dt',
        'customer_name',
        'fin_is_fin_req',
        'fin_fin_type',
        'fin_bank_id',
        'fin_stage',
        'fin_stage_dt',
        'remark_one',
        'updated_by',
        'updated_at'
    );

    public $id;
    public $vehicle_id;
    public $allotment_dt;
    public $customer_name;
    public $fin_is_fin_req;
    public $fin_fin_type;
    public $fin_bank_id;
    public $fin_stage;
    public $fin_stage_dt;
    public $remark_one;
    public $updated_by;
    public $updated_at;
}