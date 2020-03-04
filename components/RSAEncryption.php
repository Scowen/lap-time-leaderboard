<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class RSAEncryption extends Component
{
    // openssl genpkey -algorithm RSA -out private_key.pem -pkeyopt rsa_keygen_bits:2048
    // openssl rsa -pubout -in private_key.pem -out public_key.pem

    private static $privateKey;
    private static $publicKey;

    public static function encrypt($data, $file = null)
    {
        try {
            $privateFile = self::$privateKey ?: self::$privateKey = file_get_contents(Yii::getAlias("@app") . '\\private_key.pem');
            $privKey = openssl_pkey_get_private($privateFile);
            $encryptedData = "";
            openssl_private_encrypt($data, $encryptedData, $privKey);

            if ($file)
                file_put_contents($file, $encryptedData);

            return $encryptedData;
        } catch (\Exception $exc) {
            return false;
        }

    }

    public static function decrypt($data)
    {
        try {
            $publicFile = self::$publicKey ?: self::$publicKey = file_get_contents(Yii::getAlias("@app") . '\\public_key.pem');
            $pubKey = openssl_pkey_get_public($publicFile);
            $decryptedData = "";
            openssl_public_decrypt($data, $decryptedData, $pubKey);

            return $decryptedData;
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