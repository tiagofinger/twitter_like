<?php
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Test CURL Add, Edit and Remove User Twitter
 *
 * @author tiagofinger
 */
class CurlTweetTest extends PHPUnit{
    private $url = 'http://localhost/twitter_like/web/tweet';
    
    function testAddTweet() {
        $data = array('message' => 'My tweet one');
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
        $this->assertEquals('Please, send parameter message.', $resp);
        
        $data = array('username' => 'testefinger', 'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse iaculis sapien non nisi vehicula tempus. Vestibulum eu lacus ligula. Mauris magna erat, accumsan nec pulvinar vel, tincidunt vel turpis. Maecenas lorem enim, elementum et facilisis at, laoreet at lorem. In a urna nisl. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla finibus lorem non nisl blandit, vitae tincidunt libero placerat. Nunc ullamcorper justo eros, non blandit nisl sodales a. Fusce varius lacinia convallis. Phasellus venenatis eros quis massa laoreet commodo. Etiam vulputate quis risus sit amet commodo. Maecenas varius, ligula at semper rutrum, urna est porttitor augue, ut tempus dolor dui ac ligula. ');
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
        $this->assertEquals('Please, send a message with a maximum of 140 characters.', $resp);
        
        $data = array('username' => 'testefinger', 'message' => 'My tweet one');
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
        $this->assertEquals('Tweet created!', $resp);
        
        $data = array('username' => 'testefinger', 'message' => 'My tweet one');
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
        $this->assertEquals('Tweet created!', $resp);
        
        $data = array('username' => 'testefinger', 'message' => 'My tweet two');
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
        $this->assertEquals('Tweet created!', $resp);
    }

    function testEditTweet() {
        $data = array('message' => 'Another tweet');
        $url = $this->url . '/574bbdbd79b6660e5fb7acf5';
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
        $this->assertEquals('Tweet updated successfully!', $resp);
        
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
        $this->assertEquals('Tweet not exists.', $resp);
    }
    
    function testRemoveTweet() {
        $url = $this->url . '/574bbdf279b666105fb7acef';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => false,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        $this->assertEquals('Tweet not exists.', $resp);
    }
}
