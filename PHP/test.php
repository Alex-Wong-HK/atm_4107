<?php
$servername = "cslinux0.comp.hkbu.edu.hk";
$username = "comp4107_grp08";
$password = "246186";
$dbname = "comp4107_grp08";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$req = json_decode($_POST["BAMSReq"], false);
//Login
if (strcmp($req->msgType, "LoginReq") === 0) {
  $sql = "select * from card where PK_cardID = '$req->cardNo' and Password = '$req->pin'";
  $result = mysqli_query($db,$sql);
  $row = mysqli_fetch_array($result);
  // $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $active = $row['active'];
  if(mysqli_num_rows($result)==1){
    $reply->msgType = "LoginReply";
    $reply->cardNo = $req->cardNo;
    $reply->cred = "Credible Credential!!!";
  }else{
    $reply->msgType = "LoginReply";
    $reply->cred = "Wrong Password";
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