<?php


class Stock extends Db_object
{
    protected static $db_table="dispatches";
    protected static $db_table_fields=array(
        'delr',
        'city',
        'invoice_type',
        'fin_no',
        'inv_gp_no_id_id',
        'gr_no',
        'account_code',
        'model_code',
        'color',
        'chassis_prefix',
        'chassis_no',
        'engine_no',
        'invoice_dt',
        'inv_date_for_road_permit',
        'invoice_amt_rs',
        'order_category',
        'plant',
        'tin',
        'sent_by',
        'trip_consignment_no',
        'transport_reg_number',
        'indent_allot_no',
        'trans_name',
        'email_id',
        'financer',
        'veh_status',
        'mga_amount',
        'allot_status_id',
        'stock_location',
        'customer_name',
        'srm_id',
        'rm_id',
        'allotment_remark',
        'allotment_dt',
        'sms_inv_no',
        'sms_inv_dt',
        'dms_inv_no',
        'dms_inv_dt',
        'fin_is_fin_req',
        'fin_fin_type',
        'fin_bank_id',
        'fin_stage',
        'fin_stage_dt',
        'remark_one',
        'remark_two',
        'is_exchange',
        'exch_status',
        'exch_date',
        'exch_remark',
        'delivery_date',
        'delivery_datetime',
        'type'
    );
    public $id;
    public $delr;
    public $city;
    public $invoice_type;
    public $fin_no;
    public $inv_gp_no_id;
    public $gr_no_id;
    public $account_code;
    public $model_code;
    public $color;
    public $chassis_prefix;
    public $chassis_no;
    public $engine_no;
    public $invoice_dt;
    public $inv_date_for_road_permit;
    public $invoice_amt_rs;
    public $order_category;
    public $plant;
    public $tin;
    public $sent_by;
    public $trip_consignment_no;
    public $transport_reg_number;
    public $indent_allot_no;
    public $trans_name;
    public $email_id;
    public $financer;
    public $veh_status;
    public $mga_amount;
    public $allot_status_id;
    public $stock_location;
    public $customer_name;
    public $srm_id;
    public $rm_id;
    public $allotment_remark;
    public $allotment_dt;
    public $sms_inv_no;
    public $sms_inv_dt;
    public $dms_inv_no;
    public $dms_inv_dt;
    public $fin_is_fin_req;
    public $fin_fin_type;
    public $fin_bank_id;
    public $fin_stage;
    public $fin_stage_dt;
    public $remark_one;
    public $remark_two;
    public $is_exchange;
    public $exch_status;
    public $exch_date;
    public $exch_remark;
    public $delivery_date;
    public $delivery_datetime;
    public $type;



}