<?php

class Model extends DB_object
{
    protected static $db_table="models";
    protected static $db_table_fields=array('model_name','status');
    public $id;
    public $model_name;
    public $status;
    
}
//end of user class
