<?php
include '../api/db.php';

if(isset($_GET['gen'])){
    $days = $_GET['days'] ?? 30;
    $expire = date("Y-m-d H:i:s", strtotime("+$days days"));
    $key = strtoupper(bin2hex(random_bytes(16)));

    $stmt = $conn->prepare("INSERT INTO licenses (license_key, expire_at) VALUES (?, ?)");
    $stmt->bind_param("ss", $key, $expire);
    $stmt->execute();

    echo "<h3>KEY: $key</h3>";
    echo "<p>Expire: $expire</p>";
}
?>

<h2>Admin Panel</h2>

<form>
  Days: <input name="days" value="30">
  <button name="gen">Generate Key</button>
</form>
