<?php
use PHPUnit_Framework_TestCase as PHPUnit,
    \Documents\Tweet,
    \Documents\UserTwitter;

/**
 * Test tweet
 *
 * @author tiagofinger
 */
class TweetTest extends PHPUnit{
    function testMessage() {
        $tweet = new Tweet();
        $tweet->setMessage('My message');
        $this->assertEquals('My message', $tweet->getMessage());
        $tweet->setMessage('My other message');
        $this->assertEquals('My other message', $tweet->getMessage());
    }
    
    function testLike() {
        $tweet = new Tweet();
        $this->assertEquals(0, $tweet->getLike());
        $tweet->addLike();
        $this->assertEquals(1, $tweet->getLike());
        $tweet->addLike();
        $this->assertEquals(2, $tweet->getLike());
        $tweet->addLike();
        $this->assertEquals(3, $tweet->getLike());
    }
    
    function testUserTwitter() {
        $user = new UserTwitter();
        $user->setFullname('Tiago Finger');
        $user->setUsername('tiagofinger');
        
        $tweet = new Tweet();
        $tweet->setUserTwitter($user);
        $this->assertObjectHasAttribute('username', $tweet->getUserTwitter());
        $this->assertObjectHasAttribute('fullname', $tweet->getUserTwitter());
        $this->assertObjectHasAttribute('datetime', $tweet->getUserTwitter());
    }
    
    function testRetweet() {
        $user = new UserTwitter();
        $user->setFullname('Tiago Finger');
        $user->setUsername('tiagofinger');
        
        $userRetweet = new UserTwitter();
        $userRetweet->setFullname('Carlos Braga');
        $userRetweet->setUsername('carlosbraga');
        
        $tweet = new Tweet();
        $tweet->setMessage('My tweet');
        $tweet->setUserTwitter($user);
        
        $retweet = new Tweet();
        $retweet->setMessage('My retweet');
        $retweet->setUserTwitter($userRetweet);
        $tweet->setRetweet($retweet);
        $tweet->setRetweet($retweet);
        
        $tweets = $tweet->getRetweet();
        $this->assertArrayHasKey(0, $tweet->getRetweet());
        $this->assertArrayHasKey(1, $tweet->getRetweet());
        $this->assertAttributeContains('My retweet', 'message', $tweets[0]);
        $this->assertAttributeContains('My retweet', 'message', $tweets[1]);
        $this->assertAttributeContains('Carlos Braga', 'fullname', $userRetweet);
        $this->assertAttributeContains('carlosbraga', 'username', $userRetweet);
        $this->assertAttributeContains('Tiago Finger', 'fullname', $user);
        $this->assertAttributeContains('tiagofinger', 'username', $user);
    }
    
    function testDatetime() {
        $tweet = new Tweet();
        $this->assertNotEmpty($tweet->getDatetime());
    }
}
