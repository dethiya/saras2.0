<?php

class Channel extends DB_object
{
    protected static $db_table="channels";
    protected static $db_table_fields=array('channel_name','status');
    public $id;
    public $channel_name;
    public $status;
    
}
//end of channel class
