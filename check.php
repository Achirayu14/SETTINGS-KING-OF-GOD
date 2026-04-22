<?php
include 'db.php';

$key  = $_POST['key'] ?? '';
$hwid = $_POST['hwid'] ?? '';

$stmt = $conn->prepare("SELECT * FROM licenses WHERE license_key=?");
$stmt->bind_param("s", $key);
$stmt->execute();
$res = $stmt->get_result();

if(!$row = $res->fetch_assoc()){
  die(json_encode(["status"=>"invalid"]));
}

// ❌ banned
if($row['status'] !== 'active'){
  die(json_encode(["status"=>"banned"]));
}

// ⏳ expire
if(!empty($row['expire_at']) && strtotime($row['expire_at']) < time()){
  die(json_encode(["status"=>"expired"]));
}

// 🔗 bind ครั้งแรก
if(empty($row['hwid'])){
  $u = $conn->prepare("UPDATE licenses SET hwid=? WHERE license_key=?");
  $u->bind_param("ss", $hwid, $key);
  $u->execute();
  die(json_encode(["status"=>"bind_ok"]));
}

// 🔒 check hwid
if($row['hwid'] === $hwid){
  echo json_encode(["status"=>"ok"]);
} else {
  echo json_encode(["status"=>"mismatch"]);
}
