<?php

define("ADODB","/usr/local/htdocs/html/adodb/");
require_once(ADODB.'adodb.inc.php');

/*
$tipo       = "pgsql";
$host       = "localhost";
$usuario    = "tcc";
$senha      = "tcc";
$bancodados = "tcc";
*/

$tipo       = "mysql";
/* $host       = "200.20.112.2"; */
$host       = "localhost";
$usuario    = "ess";
$senha      = "ess123";
$bancodados = "ess";

/*
$tipo       = "mysql";
$host       = "localhost";
$usuario    = "locuss_tcc";
$senha      = "tcc";
$bancodados = "locuss_tcc";
*/

$db = NewADOConnection($tipo);
$db->Connect($host,$usuario,$senha,$bancodados);
$db->Execute("SET NAMES utf8");
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->debug;

?>