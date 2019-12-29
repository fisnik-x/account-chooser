<?php
/**
 * cryptography.php
 * 
 * @package Security\Cryptography
 * @author Fisnik
 * @copyright Fisnik
 * 
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree. 
 */
declare(strict_types=1);
namespace Security\Cryptography;
use \Exception;
use \RuntimeException;

/**
 *  A Tiny Cryptography Wrapper Class
 */
final class Cryptography {
    
    protected ?string $cipher = null;
    protected ?string $hash_algo = null;
    protected ?string $secret_key = null;

    /**
     * Instatiates an instance of this Cryptography class
     *
     * @param string $cipher
     * @param string $hash_algo
     * @param string $secret_key
     */
    public function __construct(?string $cipher = "aes-256-cbc", ?string $hash_algo = "sha384", 
    ?string $secret_key = "6AA55455214F78512A26F98DFE7904B319CD9E658A417BFE03EB2F28FF34E4FA")
    {
        $this->cipher = $cipher;
        $this->hash_algo = $hash_algo;
        $this->secret_key = $secret_key;
    }

    /**
     * Encrypts plain text string using built-in openssl_encrypt
     *
     * @param string $plain_text
     * @param boolean $base64_encode
     * @return string
     */
    public function encrypt(string $plain_text = "", bool $base64_encode = true) : string 
    {
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));
        
        $cipher_text = openssl_encrypt(
            $plain_text, 
            $this->cipher, 
            hex2bin($this->secret_key), 
            OPENSSL_RAW_DATA, 
            $iv
        );

        $hmac = hash_hmac($this->hash_algo, $cipher_text, $this->secret_key, true);
        return $base64_encode ? base64_encode($iv . $hmac . $cipher_text) : $iv . $hmac . $cipher_text;
    }

    /**
     * Decrypts a already ciphered text using built-in openssl_decrypt
     *
     * @param string $ciphered_text
     * @param boolean $base64_encoded
     * @return string
     */
    public function decrypt(string $ciphered_text = "", bool $base64_encoded = true) : string 
    {
        if ($base64_encoded){
            $ciphered_text = base64_decode($ciphered_text);
            assert($ciphered_text != "", 'Decoding failed.');
        }

        # Get all the sizes in bytes
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $hmac_size = mb_strlen(hash($this->hash_algo, '', true), '8bit');
        $secret_key_size = mb_strlen($this->secret_key, "8bit");   

        $iv = mb_substr($ciphered_text, 0, $ivlen, '8bit');
        $hmac = mb_substr($ciphered_text, $ivlen, $hmac_size, '8bit');
        $ciphered_text = mb_substr($ciphered_text, $secret_key_size, null, '8bit');

        $computed_hmac = hash_hmac($this->hash_algo, $ciphered_text, $this->secret_key, true);

        if (function_exists('hash_equals')){
            if (!hash_equals($hmac, $computed_hmac)){
                throw new RuntimeException("HMACs mismatch: the secret key has been tampered with.");
            }
        }

        return openssl_decrypt(
            $ciphered_text,
            $this->cipher,
            hex2bin($this->secret_key),
            OPENSSL_RAW_DATA, 
            $iv
        );
    }
}
?>