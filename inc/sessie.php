<?php
ini_set('display_errors',1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); //toon alle fouten behalve notices en warnings
setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1'));
date_default_timezone_set('Europe/Amsterdam');

session_start();
?>