<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class OpenSSLEncryption extends Component
{
    public static $key = "ThisIsSomeRandomKeyThatIThoughtAboutTypingInAFileButDidnt";

    public static function encrypt($data, $file = null)
    {
        try {
            // Remove the base64 encoding from our key
            $encryption_key = base64_decode(OpenSSLEncryption::$key);
            // Generate an initialization vector
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
            $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
            // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
            $encoded = base64_encode($encrypted . '::' . $iv);

            if ($file)
                file_put_contents($file, $encoded);

            return $encoded;
        } catch (\Exception $exc) {
            return false;
        }

    }

    public static function decrypt($data)
    {
        try {
            // Remove the base64 encoding from our key
            $encryption_key = base64_decode(OpenSSLEncryption::$key);
            // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
            list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
            return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        } catch (\Exception $exc) {
            return false;
        }
    }

    public static function decryptFromFile($file)
    {
        try {
            $data = file_get_contents($file);

            return self::decrypt($data);
        } catch (\Exception $exc) {
            return false;
        }
    }
}
