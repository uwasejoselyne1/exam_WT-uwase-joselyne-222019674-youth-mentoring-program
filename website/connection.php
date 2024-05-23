<?php
$hostname="localhost";
$user="root";
$pass="";
$database="jose";

$connection= new mysqli($hostname,$user,$pass,$database);

if($connection->connect_error){
    die("connection failed: ".$connection->connect_error);
}
?>