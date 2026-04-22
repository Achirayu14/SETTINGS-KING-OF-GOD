<?php
include 'db.php';

$key = $_POST['key'] ?? '';

$stmt = $conn->prepare("UPDATE licenses SET hwid=NULL WHERE license_key=?");
$stmt->bind_param("s", $key);

echo json_encode(["status"=>"reset_ok"]);
