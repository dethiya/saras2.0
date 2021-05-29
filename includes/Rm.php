<?php

class Rm extends DB_object
{
    protected static $db_table="rms";
    protected static $db_table_fields=array('rm_name','outlet_id','status');
    public $id;
    public $rm_name;
    public $outlet_id;
    public $status;
    
}

