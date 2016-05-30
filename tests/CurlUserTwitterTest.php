<?php
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Test CURL Add, Edit and Remove User Twitter
 *
 * @author tiagofinger
 */
class CurlUserTwitterTest extends PHPUnit{
    private $url = 'http://localhost/twitter_like/web/user';
    
    function testAddUser() {
        $data = array('fullname' => 'Test Tiago Finger');
        $url = $this->url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('Please, send parameter username.', $resp);
        
        $data = array('username' => 'testefinger');
        $url = $this->url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('Please, send parameter fullname.', $resp);
        
        $data = array('username' => 'testefinger', 'fullname' => 'Test Tiago Finger');
        $url = $this->url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User created!', $resp);
        
        $data = array('username' => 'caloslalala', 'fullname' => 'Carlos de Deus');
        $url = $this->url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User created!', $resp);
        
        $data = array('username' => 'tiagofinger', 'fullname' => 'Tiago');
        $url = $this->url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User created!', $resp);
    }
    
    function testEditUser() {
        $data = array('fullname' => 'Test Tiago Outro Finger');
        $url = $this->url . '/testefinger';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User updated successfully!', $resp);
        
        // User not exists
        $url = $this->url . '/outroteste';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => 2,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User not exists.', $resp);
    }
    
    function testRemoveUser() {
        $url = $this->url . '/tiagofinger';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEmpty($resp);
    }
    
    function testGetUser() {
        $url = $this->url . '/tiagofinger';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $json = curl_exec($curl);
        curl_close($curl);
        $this->assertJson($json);
        
        // No exists user
        $url = $this->url . '/lalalala';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('We did not find the user: lalalala', $resp);
    }
    
    function testGetUserTweet() {
        $url = $this->url . '/testefinger/tweet';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $json = curl_exec($curl);
        curl_close($curl);
        $this->assertJson($json);
        
        // No exists user
        $url = $this->url . '/popopopplll/tweet';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('User not exists.', $resp);
    }
}
