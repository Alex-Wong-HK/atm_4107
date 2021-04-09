<?php
$servername = "localhost";
$username = "comp4107_grp08";
$password = "246186";
//246186
$dbname = "comp4107_grp08";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$req = json_decode($_POST["BAMSReq"], false);
//Login
if (strcmp($req->msgType, "LoginReq") === 0) {
  $sql = "SELECT * FROM card WHERE PK_cardID = '$req->cardNo' AND Password = '$req->pin'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  if ($result->num_rows > 0) {
    $reply->msgType = "LoginReply";
    $reply->cardNo = $req->cardNo;
    $reply->cred = "abcd1234";
    $reply->status = "Suscces";
  }else{
    $reply->msgType = "LoginReply";
    $reply->status = "Fail";
  }
//
}else if (strcmp($req->msgType, "GetAccReq") === 0) {
  $reply->msgType = "GetAccReply";


} else if (strcmp($req->msgType, "WithdrawReq") === 0) {
  $reply->msgType = "WithdrawReply";


} else if (strcmp($req->msgType, "DepositReq") === 0) {
  $reply->msgType = "DepositReply";


} else if (strcmp($req->msgType, "EnquiryReq") === 0) {
  $reply->msgType = "EnquiryReply";


} else if (strcmp($req->msgType, "TransferReq") === 0) {
  $reply->msgType = "TransferReply";


}
echo json_encode($reply);
?>