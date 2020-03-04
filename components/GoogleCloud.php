<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

use Google\Cloud\Storage\StorageClient;

use app\models\Log;

class GoogleCloud extends Component
{
    private $keyFilePath;
    private $bucketName;

    public function __construct($branchObject)
    {
        $this->keyFilePath = Yii::getAlias("@app") . '/' . $branchObject->companyObject->google_cloud_key_file;
        $this->bucketName = $branchObject->bucket;
    }

    public function uploadFile($source, $objectName, $public = true)
    {
        file_put_contents(Yii::getAlias("@webroot") . "/google/$objectName", $source);

        return $this->uploadObject($objectName, $public);
    }

    public function uploadObject($objectName, $public = true, $console = true)
    {
        if (!$console && $_SERVER['REMOTE_ADDR'] == "::1")
            return true;

        $storage = new StorageClient(['keyFilePath' => $this->keyFilePath]);
        $file = fopen(Yii::getAlias("@webroot") . "/google/$objectName", 'r');
        $bucket = $storage->bucket($this->bucketName);
        $object = $bucket->upload($file, [
            'name' => $objectName
        ]);
        if ($public)
            $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);

        return true;
    }

    public function downloadObject($objectName, $destination, $console = true)
    {
        if (!$console && $_SERVER['REMOTE_ADDR'] == "::1") {
            return $this->viewObject($objectName);
        }

        $storage = new StorageClient(['keyFilePath' => $this->keyFilePath]);
        $bucket = $storage->bucket($this->bucketName);
        $object = $bucket->object($objectName);
        $object->downloadToFile($destination);

        return true;
    }

    public function viewObject($objectName, $console = true)
    {
        if (!$console && $_SERVER['REMOTE_ADDR'] == "::1") {
            return Yii::getAlias("@web") . "/google/$objectName";
        }

        return "https://storage.googleapis.com/$this->bucketName/$objectName";
    }

    public function viewPrivateObject($objectName, $console = false)
    {
        $localPath = Yii::getAlias("@webroot") . "/google/$objectName";

        if (!$console && $_SERVER['REMOTE_ADDR'] == "::1") {
            return $localPath;
        }

        if (file_exists($localPath))
            return $localPath;

        $storage = new StorageClient(['keyFilePath' => $this->keyFilePath]);
        $bucket = $storage->bucket($this->bucketName);
        $object = $bucket->object($objectName);
        $object->downloadToFile($localPath);

        return $localPath;
    }

    public function getObjects()
    {
        $storage = new StorageClient(['keyFilePath' => $this->keyFilePath]);
        $bucket = $storage->bucket($this->bucketName);

        return $bucket->objects();
    }

    public function deleteObject($bucketName, $objectName, $options = [])
    {
        $storage = new StorageClient(['keyFilePath' => $this->keyFilePath]);
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->delete();

        return true;
    }
}