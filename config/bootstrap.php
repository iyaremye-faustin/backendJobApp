<?php
require_once realpath("vendor/autoload.php");
$databaseConfig = dirname(__FILE__) . "./database.php";

if (is_readable($databaseConfig)) {
    require_once $databaseConfig;
}

?>
