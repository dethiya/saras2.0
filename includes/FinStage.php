<?php


class FinStage extends Db_object
{
    protected static $db_table='fin_stage';
    protected static $db_table_fields=array('stage_name','state');

    public $id;
    public $stage_name;
    public $state;


}