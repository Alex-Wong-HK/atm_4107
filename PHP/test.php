<?php
$servername = "cslinux0.comp.hkbu.edu.hk";
$username = "comp4107_grp08";
$password = "246186";
$dbname = "comp4107_grp08";
$conn = new mysqli($servername, $username, $password, $dbname);
$account = "";

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
  $sql = "select PK_cardID from card where PK_cardID = '$req->cardNo'";
  $account = mysqli_query($db,$sql);
  $reply->msgType = "GetAccReply";
  $reply->cardNo = $req->cardNo;
  $reply->cred = "Get account success";
  $reply->accounts = $account;


} else if (strcmp($req->msgType, "WithdrawReq") === 0) {
  $sql = "select balance from card where PK_cardID = '$req->cardNo'";
  $balance = mysqli_query($db,$sql);
  //$row = mysqli_fetch_array($balance);
  if($balance > $req->amount){
    $sql = "update card set balance = '$balance' - '$req->amount' where PK_cardID = cardID";
    $reply->msgType = "WithdrawReply";
    $reply->cardNo = $req->cardNo;
    $reply->accNo = $account;
    $reply->cred = "Withdraw Success";
  }else(){
    $reply->msgType = "WithdrawReply";
    $reply->cred = "Not enough money";
  }
  
  
} else if (strcmp($req->msgType, "DepositReq") === 0) {
  $sql = "select balance from card where PK_cardID = '$req->cardNo'";
  $balance = mysqli_query($db,$sql);
  $sql = "update card set balance = '$balance' + '$req->amount' where PK_cardID = cardID";
  $reply->msgType = "DepositReply";
  $reply->cardNo = $req->cardNo;
  $reply->accNo = $account;
  $reply->cred = "Deposit Success";

} else if (strcmp($req->msgType, "EnquiryReq") === 0) {
  $sql = "select balance from card where PK_cardID = '$req->cardNo'";
  $balance = mysqli_query($db,$sql);
  $reply->msgType = "EnquiryReply";
  $reply->cardNo = $req->cardNo;
  $reply->accNo = $account;
  $reply->balance = $balance;
  $reply->cred = "Enquiry Success";

} else if (strcmp($req->msgType, "TransferReq") === 0) {
  $sql = "select balance from card where PK_cardID = '$req->cardNo'";
  $balance = mysqli_query($db,$sql);
  if($balance > $req->amount){
    $sql1 = "update card set balance = '$balance' - '$req->amount' where account = '$account'";
    $sql2 = "update card set balance = '$balance' + '$req->amount' where account = '$req->toAcc'";
    $reply->msgType = "TransferReply";
    $reply->cardNo = $req->cardNo;
    $reply->cred = "Withdraw Success";
    $reply->fromAcc = $req->fromAcc;
    $reply->toAcc = $req->toAcc;
    $reply->amount = $req->amount;
  }else(){
    $reply->msgType = "TransferReply";
    $reply->cred = "Not enough money";
  }


}
echo json_encode($reply);
?>