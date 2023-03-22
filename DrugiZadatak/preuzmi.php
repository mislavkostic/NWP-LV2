<?php
session_start();
$file = $_GET['file'];
$decryption_key = md5('kljuc za enkripciju');
$cipher = "AES-128-CTR";
$options = 0;
$decryption_iv = $_SESSION['iv'];
$contentEncrypted = file_get_contents("uploads/$file.txt");
$contentDecrypted = base64_decode($contentEncrypted);
$data = openssl_decrypt($contentDecrypted, $cipher, $decryption_key, $options, $decryption_iv);
$file = "uploads/$file";
file_put_contents($file, $data);

if(file_exists($file)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    ob_clean();
    readfile($file);
    unlink($file);

    die();
}
