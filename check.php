<?php
include 'db.php';

$key = $_GET['key'] ?? '';
$hwid = $_GET['hwid'] ?? '';

$sql = "SELECT * FROM license_keys WHERE license_key = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $key);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    // เช็ควันหมดอายุ
    if (strtotime($row['expiry_date']) < time()) {
        echo "EXPIRED";
        exit;
    }

    // เช็ค HWID
    if ($row['hwid'] == NULL) {
        // bind ครั้งแรก
        $update = $conn->prepare("UPDATE license_keys SET hwid=? WHERE license_key=?");
        $update->bind_param("ss", $hwid, $key);
        $update->execute();
        echo "OK";
    } else if ($row['hwid'] == $hwid) {
        echo "OK";
    } else {
        echo "HWID_MISMATCH";
    }

} else {
    echo "INVALID";
}
