<?php
include 'db.php';

$key = $_POST['key'] ?? '';

$stmt = $conn->prepare("UPDATE licenses SET status='banned' WHERE license_key=?");
$stmt->bind_param("s", $key);

echo json_encode(["status"=>"banned"]);
