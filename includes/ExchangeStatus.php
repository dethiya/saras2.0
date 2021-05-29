<?php


class ExchangeStatus extends Db_object
{
    protected static $db_table='exchange_status';
    protected static $db_table_fields=array('status_desc','state');

    public $id;
    public $status_desc;
    public $state;


}