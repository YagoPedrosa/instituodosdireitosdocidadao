<?php
$passwd = substr(md5(uniqid(rand(), true)), 0, 10);
$senhaX = 'LabsDesign' . $passwd . '?ldr3#0804';
$passwd_grava = md5($senhaX);
