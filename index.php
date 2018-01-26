<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'String Shop';
require_once('Views/index.phtml');