<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** @MongoDB\Document **/
class Tweet {
   /**
    * @MongoDB\Id(type="integer")
    */
    private $id;
    
    /**
     * @MongoDB\Integer
     */
    private $userTwitter;
    
    /** 
     * @MongoDB\String 
     */
    private $message;
    
    /** 
     * @MongoDB\Date 
     */
    private $datetime;
    
    /** 
     * @MongoDB\Integer 
     */
    private static $likes = 0;
    
    /**
     * @@MongoDB\ReferenceMany(targetDocument="Tweet")
     */
    private $retweets;
    
    public function __construct() {
        $this->datetime = time();
    }
    
    public function setUserTwitter($userTwitter) {
        $this->userTwitter = $userTwitter;
    }
    
    public function setMessage($message) {
        $this->message = $message;
    }
    
    public function setRetweet(Tweet $tweet) {
        $this->retweets[] = $tweet;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUserTwitter() {
        return $this->userTwitter;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function getRetweet() {
        return $this->retweets;
    }
    
    public function getLike() {
        return self::$likes;
    }
    
    public function getDatetime() {
        return $this->datetime;
    }
    
    public function addLike() {
        self::$likes++;
    }
    
    public function toArray() {
        return array('id' => $this->id, 'userTwitter' => $this->userTwitter, 'message' => $this->message, 'datetime' => $this->datetime, 'retweet' => $this->retweets, 'like' => self::$likes);
    }
    
    public function toJson() {
        return json_encode($this->toArray());
    }
}
