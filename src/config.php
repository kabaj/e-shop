<?php

$server= "localhost";
$username = "root";
$password = "coderslab";
$database = "shop";

$conn = new mysqli($server, $username, $password, $database);
$result = $conn->query($conn);

if($result->num_rows>0){
    echo ("jest polaczone");
} else{
    echo ("brak polaczenia");
}

$conn->close();


?>