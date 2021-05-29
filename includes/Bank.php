<?php

class Bank extends DB_object
{
    protected static $db_table="banks";
    protected static $db_table_fields=array('bank_name','bank_branch','status');
    public $id;
    public $bank_name;
    public $bank_branch;
    public $status;
    
}

