<?php

// Encryption code from https://stackoverflow.com/a/64024743/2901480

function encrypt($encryptionKey, $data) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-gcm'));
    $encrypted = openssl_encrypt($data, 'aes-256-gcm', $encryptionKey, OPENSSL_RAW_DATA, $iv, $tag);
    return base64_encode($iv . $tag . $encrypted);
}

function decrypt($encryptionKey, $data) {
    $c = base64_decode($data);
    $ivlen = openssl_cipher_iv_length($cipher="AES-256-GCM");
    $iv = substr($c, 0, $ivlen);
    $tag = substr($c, $ivlen, $taglen=16);
    $ciphertext_raw = substr($c, $ivlen+$taglen);
    return openssl_decrypt($ciphertext_raw, 'aes-256-gcm', $encryptionKey, OPENSSL_RAW_DATA, $iv, $tag);
}
?>