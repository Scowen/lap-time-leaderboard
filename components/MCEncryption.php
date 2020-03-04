<?php
namespace app\components;

error_reporting(E_ALL ^ E_DEPRECATED);

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MCEncryption extends Component
{
    public static $key = "ThisIsSomeRandomKeyThatIThoughtAboutTypingInAFileButDidnt";

    public static function encrypt($encrypt, $file = null)
    {
        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_RAND);
        $key = pack('H*', MCEncryption::$key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
        if ($file)
            file_put_contents($file, $encoded);
        return $encoded;
    }

    public static function decrypt($decrypt){
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', MCEncryption::$key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return $decrypted;
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
