<?php

namespace App\Helpers;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\RSA;

class CryptoHelper
{
    /**
     * Enkripsi file menggunakan AES
     */
    public static function encryptFileAES($fileContent, $key)
    {
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV(substr($key, 0, 16)); // Inisialisasi IV dengan 16 karakter pertama dari kunci
        return $aes->encrypt($fileContent);
    }

    /**
     * Dekripsi file menggunakan AES
     */
    public static function decryptFileAES($encryptedContent, $key)
    {
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV(substr($key, 0, 16));
        return $aes->decrypt($encryptedContent);
    }

    /**
     * Enkripsi kunci AES menggunakan RSA
     */
    public static function encryptAESKeyRSA($aesKey, $publicKey)
    {
        $rsa = RSA::loadPublicKey($publicKey);
        return $rsa->encrypt($aesKey);
    }

    /**
     * Dekripsi kunci AES menggunakan RSA
     */
    public static function decryptAESKeyRSA($encryptedKey, $privateKey)
    {
        $rsa = RSA::loadPrivateKey($privateKey);
        return $rsa->decrypt($encryptedKey);
    }
}