<?php
/**
 * Destroy any session that is running and redirect
 * the user to the index page
 */
session_start();
session_destroy();
header('Location: index.php');