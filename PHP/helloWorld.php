<?php
$servername = "localhost";
$username = "comp4107_grp08";
$password = "246186";
//246186
$dbname = "comp4107_grp08";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: "; 
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT PK_cardID, Account, Password FROM card";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo json_encode($row);
    }
  }else{

    echo "Not Record"; 
  }

  
?>