<?php

include "db.php";


$id=$_GET['id'];


$sql="DELETE FROM Vehicle WHERE Vehicle_ID=$id";


mysqli_query($conn,$sql);


header("Location: vehicle_management.php");


?>