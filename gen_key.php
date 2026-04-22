<?php
include 'db.php';

function genKey($len=32){
  return strtoupper(bin2hex(random_bytes($len/2)));
}

$days = $_GET['days'] ?? 30; // กำหนดวัน
$expire = date("Y-m-d H:i:s", strtotime("+$days days"));

$key = genKey();

$stmt = $conn->prepare("INSERT INTO licenses (license_key, expire_at) VALUES (?, ?)");
$stmt->bind_param("ss", $key, $expire);

echo json_encode([
  "status"=>"ok",
  "key"=>$key,
  "expire"=>$expire
]);
