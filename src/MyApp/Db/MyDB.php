<?php
namespace MyDB;

use Silex\Application,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver,
    Doctrine\ODM\MongoDB\DocumentManager;

class MyDB {
    private static $conn;
    
    public static function getInstance(Application $app) {
        if (self::$conn == null) {
            /** Configure ODM **/
            $config = new Configuration();
            $config->setProxyDir(__DIR__ . '/cache');
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir(__DIR__ . '/cache');
            $config->setHydratorNamespace('Hydrators');

            $annotationDriver = $config->newDefaultAnnotationDriver(array(__DIR__ . '/Documents'));
            $config->setMetadataDriverImpl($annotationDriver);
            AnnotationDriver::registerAnnotationClasses();

            self::$conn = DocumentManager::create($app['mongodb'], $config);
        }
        
        return self::$conn;
    } 
}
