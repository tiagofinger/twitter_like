<?php
use PHPUnit_Framework_TestCase as PHPUnit,
    \Documents\UserTwitter;

/**
 * Test user twitter
 *
 * @author tiagofinger
 */
class UserTwitterTest extends PHPUnit{
    function testUsername() {
        $user = new UserTwitter();
        $user->setUsername('tiagofinger');
        $this->assertEquals('tiagofinger', $user->getUsername());
        $user->setUsername('carlosandre');
        $this->assertEquals('carlosandre', $user->getUsername());
        $user->setUsername('jucamachado');
        $this->assertEquals('jucamachado', $user->getUsername());
    }
    
    function testFullname() {
        $user = new UserTwitter();
        $user->setUsername('Tiago Finger');
        $this->assertEquals('Tiago Finger', $user->getUsername());
        $user->setUsername('João de Deus');
        $this->assertEquals('João de Deus', $user->getUsername());
    }
    
    function testDatetime() {
        $user = new UserTwitter();
        $this->assertNotEmpty($user->getDatetime());
    }
}
