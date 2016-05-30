<?php
use PHPUnit_Framework_TestCase as PHPUnit,
    MyDB\MyDB,
    Silex\Application,
    Saxulum\DoctrineMongoDb\Silex\Provider\DoctrineMongoDbProvider;

/**
 * Test tweet
 *
 * @author tiagofinger
 */
class DBTest extends PHPUnit{
    function testDB() {
        $app = new Application();
        /** MongoDB **/
        $app->register(new DoctrineMongoDbProvider(), array(
            'mongodb.options' => array(
                'server' => 'mongodb://localhost:27017',
                'options' => array(
                    'db' => 'twitter_like'
                )
            )
        ));
        $this->assertNotEmpty(MyDB::getInstance($app));
        $this->assertNotEmpty(MyDB::getInstance($app));
        $this->assertNotEmpty(MyDB::getInstance($app));
    }
}
