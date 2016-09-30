<?php
$try=123;
 try{
 	echo gettype();

 }catch (Exception $e){
 	echo 'Caugth exception: ', $e->getMessage();

 }