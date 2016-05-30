<?php
use Silex\Application,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Saxulum\DoctrineMongoDb\Silex\Provider\DoctrineMongoDbProvider,
    MyDB\MyDB;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

/** Routes **/
$app->get('/', function () use ($app) {
    return 'API Rest Twitter like.';
});

/** Get User **/
$app->get('/user/{username}', function ($username) use ($app){
    $dm = MyDB::getInstance($app);
    $user = $dm->getRepository('Documents\UserTwitter')->findOneByUsername($username);
    
    if (empty($user)) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = "We did not find the user: $username";
    } else {
        $code = Response::HTTP_OK;
        $message = $user->toJson();
    }
    return new Response($message, $code);
});

/** Get Tweet **/
$app->get('user/{username}/tweet', function ($username) use ($app){
    $dm = MyDB::getInstance($app);
    $user = $dm->getRepository('Documents\UserTwitter')->findOneByUsername($username);

    if (empty($user)) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'User not exists.';
    } else {
        $tweets = $dm->getRepository('Documents\Tweet')->findBy(array('userTwitter' => (int) $user->getId()));
        if (empty($tweets)) {
            $code = Response::HTTP_BAD_REQUEST;
            $message = "We did not find the tweet: $username";
        } else {
            $code = Response::HTTP_OK;
            
            $data = array();
            foreach ($tweets as $arr) {
                $data[] = $arr->toArray();
            }
            $message = json_encode($data);
        }
    }
    return new Response($message, $code);
});

/** Save User **/
$app->post('/user', function (Request $request) use ($app) {
    if (empty($request->get('username'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter username.';
    } else if (empty($request->get('fullname'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter fullname.';
    } else {
        $user = new \Documents\UserTwitter();
        $user->setUsername($request->get('username'));
        $user->setFullname($request->get('fullname'));
        
        $dm = MyDB::getInstance($app);
        $dm->persist($user);
        $dm->flush();
        
        $code = Response::HTTP_CREATED;
        $message = 'User created!';
    }
    
    return new Response($message, $code);
});

/** Update User **/
$app->put('/user/{username}', function (Request $request, $username) use ($app) {
    if (empty($request->get('fullname'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter fullname.';
    } else {
        $dm = MyDB::getInstance($app);
        $user = $dm->getRepository('Documents\UserTwitter')->findOneByUsername($username);
        if (empty($user)) {
            $code = Response::HTTP_BAD_REQUEST;
            $message = 'User not exists.';
        } else {
            $user->setFullname($request->get('fullname'));
            $dm->flush();
            
            $code = Response::HTTP_OK;
            $message = 'User updated successfully!';
        }
    }
    
    return new Response($message, $code);
});

/** Delete User **/
$app->delete('/user/{username}', function ($username) use ($app) {
    $dm = MyDB::getInstance($app);
    $user = $dm->getRepository('Documents\UserTwitter')->findOneByUsername($username);
    
    if (empty($user)) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'User not exists.';
    } else {
        $dm->remove($user);
        $dm->flush();
        
        $code = Response::HTTP_NO_CONTENT;
        $message = 'User deleted successfully.';
    }
    
    return new Response($message, $code);
});

/** Get Tweet **/
$app->get('/tweet/{id}', function ($id) use ($app){
    $dm = MyDB::getInstance($app);
    
    $tweet = $dm->getRepository('Documents\Tweet')->findById($id);
    if (empty($tweet)) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = "We did not find the tweet: $id";
    } else {
        $code = Response::HTTP_OK;
        $message = $tweet[0]->toJson();
    }
    return new Response($message, $code);
});

/** Save Tweet **/
$app->post('/tweet', function (Request $request) use ($app) {
    if (empty($request->get('username'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter username.';
    } else if (empty($request->get('message'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter message.';
    } else if (strlen($request->get('message')) > 140) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send a message with a maximum of 140 characters.';
    } else {
        $dm = MyDB::getInstance($app);
        $user = $dm->getRepository('Documents\UserTwitter')->findOneByUsername($request->get('username'));
        
        if (empty($user)) {
            $code = Response::HTTP_BAD_REQUEST;
            $message = 'User not exists.';
        } else {
            $tweet = new \Documents\Tweet();
            $tweet->setMessage($request->get('message'));
            $tweet->setUserTwitter($user->getId());
            $dm->persist($tweet);
            $dm->flush();
        
            $code = Response::HTTP_CREATED;
            $message = 'Tweet created!';
        }
    }
    return new Response($message, $code);
});

/** Update Tweet **/
$app->put('/tweet/{id}', function (Request $request, $id) use ($app) {
    if (empty($request->get('message'))) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Please, send parameter fullname.';
    } else {
        $dm = MyDB::getInstance($app);
        $tweet = $dm->getRepository('Documents\Tweet')->findById($id);
        if (empty($tweet)) {
            $code = Response::HTTP_BAD_REQUEST;
            $message = 'Tweet not exists.';
        } else {
            $tweet[0]->setMessage($request->get('message'));
            $dm->persist($tweet[0]);
            $dm->flush();
            
            $code = Response::HTTP_OK;
            $message = 'Tweet updated successfully!';
        }
    }
    
    return new Response($message, $code);
});

/** Delete Tweet **/
$app->delete('/tweet/{id}', function ($id) use ($app) {
    $dm = MyDB::getInstance($app);
    $tweet = $dm->getRepository('Documents\Tweet')->findById($id);
    
    if (empty($tweet)) {
        $code = Response::HTTP_BAD_REQUEST;
        $message = 'Tweet not exists.';
    } else {
        $dm->remove($tweet[0]);
        $dm->flush();
        
        $code = Response::HTTP_NO_CONTENT;
        $message = 'Tweet deleted successfully.';
    }
    
    return new Response($message, $code);
});

/** MongoDB **/
$app->register(new DoctrineMongoDbProvider(), array(
    'mongodb.options' => array(
        'server' => 'mongodb://localhost:27017',
        'options' => array(
            'db' => 'twitter_like'
        )
    )
));
        
$app->run();