<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR) ;

// for local
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'seva') ;

// for web
// define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']) ;


defined('INCLUDES_PATH')? null : define('INCLUDES_PATH', SITE_ROOT.DS.'includes'); 
require_once (INCLUDES_PATH.DS.'functions.php');
require_once (INCLUDES_PATH.DS.'new_config.php');
require_once (INCLUDES_PATH.DS.'Database.php');
require_once (INCLUDES_PATH.DS.'DB_object.php');
require_once (INCLUDES_PATH.DS.'Channel.php');
require_once (INCLUDES_PATH.DS.'Outlet.php');
require_once (INCLUDES_PATH.DS.'Model.php');
require_once (INCLUDES_PATH.DS.'Variant.php');
require_once (INCLUDES_PATH.DS.'Color.php');
require_once (INCLUDES_PATH.DS.'StockLocation.php');
require_once (INCLUDES_PATH.DS.'Srm.php');
require_once (INCLUDES_PATH.DS.'Rm.php');
require_once (INCLUDES_PATH.DS.'Bank.php');
require_once (INCLUDES_PATH.DS.'User.php');
require_once (INCLUDES_PATH.DS.'Photo.php');
require_once (INCLUDES_PATH.DS.'DeliveryDatabase.php');
require_once (INCLUDES_PATH.DS.'Session.php');
require_once (INCLUDES_PATH.DS.'Stock.php');
require_once (INCLUDES_PATH.DS.'AllotStatus.php');
require_once (INCLUDES_PATH.DS.'FinStage.php');
require_once (INCLUDES_PATH.DS.'ExchangeStatus.php');
require_once (INCLUDES_PATH.DS.'PDI_History.php');
require_once (INCLUDES_PATH.DS.'AllotHistory.php');
require_once (INCLUDES_PATH.DS.'FinanceHistory.php');
require_once (INCLUDES_PATH.DS.'ExchangeHistory.php');
require_once (INCLUDES_PATH.DS.'Indent.php');