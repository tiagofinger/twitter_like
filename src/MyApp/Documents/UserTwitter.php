<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB,
    Doctrine\Common\Collections\ArrayCollection;

/** @MongoDB\Document **/
class UserTwitter { 
    /**
    * @MongoDB\Id(type="integer")
    */
    private $id;

    /** 
     * @MongoDB\String 
     */
    private $username;
    
    /** 
     * @MongoDB\String 
     */
    private $fullname;
    
    /** 
     * @MongoDB\Date 
     */
    private $datetime;
    
    /** 
     * @MongoDB\ReferenceMany(targetDocument="Tweet", mappedBy="userTwitter") 
     */
    private $tweets;
    
    public function __construct() {
        $this->datetime = time();
        $this->tweets = new ArrayCollection();
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getFullname() {
        return $this->fullname;
    }
    
    public function getDatetime() {
        return $this->datetime;
    }
    
    /*public function getTweets() {
        return $this->tweets;
    }*/
    
    public function toArray() {
        return array('id' => $this->id, 'username' => $this->username, 'fullname' => $this->fullname, 'datetime' => $this->datetime, 'tweets' => $this->tweets);
    }
    
    public function toJson() {
        return json_encode($this->toArray());
    }
}
