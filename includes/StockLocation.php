<?php

class StockLocation extends DB_object
{
    protected static $db_table="stock_locations";
    protected static $db_table_fields=array('stock_loc_name','stock_loc_code','status');
    public $id;
    public $stock_loc_name;
    public $stock_loc_code;
    public $status;
    
}

