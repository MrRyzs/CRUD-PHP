<?php
    $host = mysqli_connect("localhost", "root", "", "db_mylibrary");
    if($host){
    } else{
        echo "Connection Failed";
    }