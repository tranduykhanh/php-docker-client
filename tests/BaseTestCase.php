<?php
namespace DockerClient\Tests;
use DockerClient\Entities\ContainerEntity;
use DockerClient\Entities\ImageEntity;
use DockerClient\Entities\VolumeEntity;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: tran.duy.khanh
 * Date: 02/06/2017
 * Time: 15:06
 */
class BaseTestCase extends TestCase
{
    protected static $testContainerName = [];
    protected static $testImageName = [];
    protected static $testVolumeName = [];

    public static function tearDownAfterClass()
    {
        self::println("--- Start clear containers: ");
        array_walk(self::$testContainerName, function ($containerName, $index) {
            $containerEntity = new ContainerEntity($containerName);
            $containerEntity->stop();
            $containerEntity->rm();
            unset(self::$testContainerName[$index]);
        });

        self::println("--- Start clear images: ");
        array_walk(self::$testImageName, function ($imageName, $index) {
            $imageEntity = new ImageEntity($imageName);
            $imageEntity->rm();
            unset(self::$testImageName[$index]);
        });

        self::println("--- Start clear volumes: ");
        array_walk(self::$testVolumeName, function ($volumeName, $index) {
            $volumeEntity = new VolumeEntity($volumeName);
            $volumeEntity->rm();
            unset(self::$testVolumeName[$index]);
        });
    }

    public function getRandomContainerName()
    {
        $containerName = 'container' . rand(1, 10000000);
        array_push(self::$testContainerName, $containerName);
        $this->println("---Attempt to create new container: $containerName");
        return $containerName;
    }

    public function getRandomImageName()
    {
        $imageName = 'image' . rand(1, 10000000);
        array_push(self::$testImageName, $imageName);
        $this->println("---Attempt to create new image: $imageName");
        return $imageName;
    }

    public function getRandomVolumeName()
    {
        $volumeName = 'volume' . rand(1, 10000000);
        array_push(self::$testVolumeName, $volumeName);
        $this->println("---Attempt to create new volume: $volumeName");
        return $volumeName;
    }

    private static function println($str){
        echo "\n$str\n";
    }

    protected static function removeEntityByValue(&$entity, $value){
        if (($key = array_search($value, $entity)) !== false) {
            unset($entity[$key]);
        }
    }
}