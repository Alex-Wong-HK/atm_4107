<?php
$servername = "localhost";
$username = "comp4107_grp08";
$password = "246186";
//246186
$dbname = "comp4107_grp08";
$conn = new mysqli($servername, $username, $password, $dbname);
$cred = "";

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
    $newCred = random_string(10);
    $reply->msgType = "LoginReply";
    $reply->cardNo = $req->cardNo;
    $reply->cred = $newCred;
    $cred = $newCred;
    $reply->status = "Suscces";
  }else{
    $reply->msgType = "LoginReply";
    $reply->status = "Fail";
  }
//
}else if (strcmp($req->msgType, "GetAccReq") === 0) {
  $sql = "SELECT PK_cardID FROM card WHERE PK_cardID = '$req->cardNo' AND Password = '$req->pin'";
  $account = $conn->query($sql);
  $reply->msgType = "GetAccReply";
  $reply->cardNo = $req->cardNo;
  $reply->cred = $cred;
  $reply->status = "Suscces";
  


} else if (strcmp($req->msgType, "WithdrawReq") === 0) {
  if($cred === $req->cred){
    $sql = "SELECT Balance FROM card WHERE PK_cardID = '$req->cardNo'";
    $balance = $conn->query($sql);
    $reply->msgType = "WithdrawReply";
    if($balance > $req->amount){
      $sql = "UPDATE card set Balance = '$balance' - '$req->anount' where PK_cardID = '$req->cardNo'";
      $reply->msgType = "WithdrawReply";
      $reply->cardNo = $req->cardNo;
      $reply->accNo = $req->accNo;
      $reply->cred = $req->cred;
      $reply->amount = $req->amount;
      $reply->outAmount = $req->amount;
      $reply->status = "Suscces";
    }else(){
      $reply->msgType = "WithdrawReply";
      $reply->status = "Fail";
    }
  }else(){
    $reply->msgType = "WithdrawReply";
    $reply->status = "Wrong cred";
  }


} else if (strcmp($req->msgType, "DepositReq") === 0) {
  if($cred === $req->cred){
    if($cred === $req->cred){
      $sql = "SELECT Balance FROM card WHERE PK_cardID = '$req->cardNo'";
      $balance = $conn->query($sql);
      $sql = "UPDATE card set Balance = '$balance' + '$req->anount' where PK_cardID = '$req->cardNo'";
      $reply->msgType = "DepositReply";
      $reply->cardNo = $req->cardNo;
      $reply->accNo = $req->accNo;
      $reply->cred = $req->cred;
      $reply->amount = $req->amount;
      $reply->depAmount = $req->amount;
      $reply->status = "Suscces";
    }
  }else(){
    $reply->msgType = "WithdrawReply";
    $reply->status = "Wrong cred";
  }


} else if (strcmp($req->msgType, "EnquiryReq") === 0) {
  if($cred === $req->cred){
    $sql = "SELECT Balance FROM card WHERE PK_cardID = '$req->cardNo'";
    $balance = $conn->query($sql);
    $reply->msgType = "EnquiryReply";
    $reply->cardNo = $req->cardNo;
    $reply->accNo = $req->accNo;
    $reply->cred = $req->cred;
    $reply->amount = $balance;
    $reply->status = "Suscces";
  }else(){
    $reply->msgType = "WithdrawReply";
    $reply->status = "Wrong cred";
  }


} else if (strcmp($req->msgType, "TransferReq") === 0) {
  if($cred === $req->cred){
    $sql = "SELECT Balance FROM card WHERE PK_cardID = '$req->cardNo'";
    $balance = $conn->query($sql);
    if($balance > $req->amount){
      $sql1 = "UPDATE card set Balance = '$balance' - '$req->anount' where account = '$req->fromAcc'";
      $result1 = $conn->query($sql1);
      $sql2 = "UPDATE card set Balance = '$balance' + '$req->anount' where account = '$req->toAcc'";
      $result2 = $conn->query($sql2);
      $reply->msgType = "TransferReply";
      $reply->cardNo = $req->cardNo;
      $reply->cred = $req->cred;
      $reply->fromAcc = $req->fromAcc;
      $reply->toAcc = $req->toAcc;
      $reply->amount = $req->amount;
      $reply->transAmount = $req->amount;
      $reply->status = "Suscces";
    }else(){
      $reply->msgType = "TransferReply";
      $reply->status = "Fail";
    }
  }else(){
    $reply->msgType = "TransferReply";
    $reply->status = "Wrong cred";
  }


}else if (strcmp($req->msgType, "AccStmtReq") === 0) {
  if($cred === $req->cred){
    $reply->msgType = "AccStmtReply";
    $reply->cardNo = $req->cardNo;
    $reply->accNo = $req->accNo;
    $reply->cred = $req->cred;
    $reply->result = "succ";
  }else(){
    $reply->msgType = "AccStmtReply";
    $reply->result = "Wrong cred";
  }


}else if (strcmp($req->msgType, "ChqBookReq") === 0) {
  if($cred === $req->cred){
    $reply->msgType = "ChqBookReply";
    $reply->cardNo = $req->cardNo;
    $reply->accNo = $req->accNo;
    $reply->cred = $req->cred;
    $reply->result = "succ";
  }else(){
    $reply->msgType = "ChqBookReply";
    $reply->result = "Wrong cred";
  }

}else if (strcmp($req->msgType, "ChgPinReq") === 0) {
  if($cred === $req->cred){
    $sql = "UPDATE card set Password = '$req->newPin' where PK_cardID = '$req->cardNo' AND Password = '$req->oldPin'";
    $result = $conn->query($sql);
    $reply->msgType = "ChgPinReply";
    $reply->cardNo = $req->cardNo;
    $reply->oldPin = $req->oldPin;
    $reply->newPin = $req->newPin;
    $reply->cred = $req->cred;
    $reply->result = "succ";
  }else(){
    $reply->msgType = "ChgPinReply";
    $reply->result = "fail";
  }



}else if (strcmp($req->msgType, "ChgLangReq") === 0) {
  if($cred === $req->cred){
    $sql = "UPDATE card set Language = '$req->newLang' where PK_cardID = '$req->cardNo' AND Password = '$req->oldPin'";
    $reply->msgType = "ChgLangReply";
    $reply->cardNo = $req->cardNo;
    $reply->oldLang = $req->oldLang;
    $reply->newLang = $req->newLang;
    $reply->cred = $req->cred;
    $reply->result = "succ";
  }else(){
    $reply->msgType = "ChgLangReply";
    $reply->result = "fail";
  }

}


echo json_encode($reply);

function random_string($length) {
  $key = '';
  $keys = array_merge(range(0, 9), range('a', 'z'));

  for ($i = 0; $i < $length; $i++) {
      $key .= $keys[array_rand($keys)];
  }

  return $key;
}
?>