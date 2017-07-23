<?php
require('notify.php');

$id = $_GET['id'];

Notifications::markNotificationRead($id);