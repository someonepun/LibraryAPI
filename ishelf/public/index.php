<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
//require '../INCLUDES/DbConnect.php';
require '../INCLUDES/DbOperations.php';


$app = new \Slim\App;

$app = new \Slim\App([
    'settings'=> [
        'displayErrorDetails'=>true
    ]
]);
/*
    endpoint: createuser
    parameters: name, email, LondonMetID, password
    method: POST
*/
///to create a POST call
$app->post('/createuser', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('name','email','LondonMetID','password'), $request, $response)){
        
        $request_data = $request->getParsedBody(); //stores all the data 
        $name = $request_data['name'];
        $email = $request_data['email'];
        $londonID = $request_data['LondonMetID'];
        $password = $request_data['password'];
        
        //password encryption
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        
        $db = new DbOperations;
        
        $result = $db->createUser($name, $email,$londonID,$hash_password);
        //print_r($result);

        if($result == USER_CREATED){
            $message = array();
            $message['error'] = false; //no error
            $message['message'] = 'User created successfully';

            $response->write(json_encode($message));
            return $response
                        -> withHeader('Content-type','application/json')
                        -> withStatus(201); //http code 201 which request is success
        }else if ($result == USER_FAILURE){
            $message = array();
            $message['error'] = true;
            $message['message'] = 'Some error occured';

            $response->write(json_encode($message));
            return $response
                        -> withHeader('Content-type','application/json')
                        -> withStatus(422);

        }else if ($result==USER_EXISTS){
            $message = array();
            $message['error'] = true;
            $message['message'] = 'User already exist';

            $response->write(json_encode($message));
            return $response
                        -> withHeader('Content-type','application/json')
                        -> withStatus(422);
        }
    }
    return $response
                        -> withHeader('Content-type','application/json')
                        -> withStatus(422);
});

//to user login
$app->post('/userlogin', function (Request $request, Response $response){
    if(!haveEmptyParameters(array('email','password'), $request, $response)){
        $request_data = $request->getParsedBody(); 
        $email = $request_data['email'];
        $password = $request_data['password'];
        
        $db = new DbOperations;
        $result = $db->userLogin($email, $password);
         
        if($result == USER_AUTHENTICATED){
            $user = $db->getUserByEmail($email);

            $response_data = array();
            $response_data['error']= false;
            $response_data['message'] = 'Login Successful';
            $response_data['user'] = $user;

            $response->write(json_encode($response_data));
            return $response
            -> withHeader('Content-type','application/json')
            -> withStatus(200);

        }else if($result == USER_NOT_FOUND){
            $response_data = array();
            
            $response_data['error']= true;
            $response_data['message'] = 'User not exist';

            $response->write(json_encode($response_data));
            return $response
            -> withHeader('Content-type','application/json')
            -> withStatus(200);

        }else if ($result == USER_PASSWORD_DO_NOT_MATCH){
            $user = $db->getUserByEmail($email);

            $response_data = array();
            $response_data['error']= true;
            $response_data['message'] = 'Invalid credintial';
            $response_data['user'] = $user;

            $response->write(json_encode($response_data));
            return $response
                -> withHeader('Content-type','application/json')
                -> withStatus(200);
        }
    }
    return $response
                ->withHeader('Content-type','application.json')
                ->withStatus(422);
});

//GET request to get all the users forom database
$app->get('/allusers', function(Request $request, Response $response){
            $db = new DbOperations; 
            $users = $db->getAllUsers();
            $response_data = array(); 
            $response_data['error'] = false;  //means no error
            $response_data['users'] = $users; //user that is fetched from database
            $response->write(json_encode($response_data));
            return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(200);  //status 200 means OK
});

//BOOKS---------------
//GET request to get all the books forom database
$app->get('/allbooks[/{key}]', function(Request $request, Response $response,$args){
    $key = $args['key'];
    $db = new DbOperations; 
    $books = $db->getAllBooksInfo($key);
    $response_data = array(); 
    $response_data['error'] = false;  //means no error
    $response_data['books'] = $books; //user that is fetched from database
    $response->write(json_encode($response_data));
    return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);  //status 200 means OK
});

//search books
$app->get('/searchbooks/{name}', function($request, $response, $args){
    $key = $args['name'];
    $db = new DbOperations; 
    $books = $db->getAllBooksInfoSearch($key);
    $response_data = array(); 
    $response_data['error'] = false;  //means no error
    $response_data['books'] = $books; //user that is fetched from database
    $response->write(json_encode($response_data));
    return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);  //status 200 means OK  
});

//To UPDATE user information
$app->put('/updateuser/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    if(!haveEmptyParameters(array('name','email','id'), $request, $response)){
        $request_data = $request->getParsedBody(); 
        $name = $request_data['name'];
        $email = $request_data['email'];
        $id = $request_data['id'];

        $db = new DbOperations; //object of DbOperation

        if($db->updateUser($name, $email, $id)){
           $response_data = array(); 
           $response_data['error'] = false; //means no error
           $response_data['message'] = 'User Updated Successfully';
           $user = $db->getUserByEmail($email);
           $response_data['user'] = $user; 
           $response->write(json_encode($response_data));

           return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);  //200 means OK
       }else{
           $response_data = array(); 
           $response_data['error'] = true; 
           $response_data['message'] = 'Please try again later';
           $user = $db->getUserByEmail($email);
           $response_data['user'] = $user; 

           $response->write(json_encode($response_data));
           return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);       
       }
    }
   
   return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);  
});

//to update password
$app->put('/updatepassword', function(Request $request, Response $response){
    if(!haveEmptyParameters(array('currentpassword', 'newpassword', 'email'), $request, $response)){
       
        $request_data = $request->getParsedBody(); 
        $currentpassword = $request_data['currentpassword'];
        $newpassword = $request_data['newpassword'];
        $email = $request_data['email']; 
        $db = new DbOperations; 

        $result = $db->updatePassword($currentpassword, $newpassword, $email);
        if($result == PASSWORD_CHANGED){
           $response_data = array(); 
           $response_data['error'] = false;
           $response_data['message'] = 'Password Changed Sucessfully';
           $response->write(json_encode($response_data));
           return $response->withHeader('Content-type', 'application/json')
                           ->withStatus(200);
        }else if($result == PASSWORD_DO_NOT_MATCH){
           $response_data = array(); 
           $response_data['error'] = true;
           $response_data['message'] = 'You have given wrong password';
           $response->write(json_encode($response_data));
           return $response->withHeader('Content-type', 'application/json')
                           ->withStatus(200);
       }else if($result == PASSWORD_NOT_CHANGED){
           $response_data = array(); 
           $response_data['error'] = true;
           $response_data['message'] = 'Some error occurred';
           $response->write(json_encode($response_data));
           return $response->withHeader('Content-type', 'application/json')
                           ->withStatus(200);
       }
   }
    return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(422);  
});

//to check required parameters are empty or not
function haveEmptyParameters($required_params, $request,$response){
    $error =false; //all parameters are empty assume
    $error_params ='';
    $request_params = $request->getParsedBody();

    foreach($required_params as $param){
        if(!isset($request_params[$param]) || strlen($request_params[$param])<=0){
            $error = true;
            $error_params.= $param.', ';
        }//if Ture == parameter is empty
    }

    if($error){
        $error_detail = array();
        $error_detail['error'] = true;
        $error_detail['message']= 'Required parameters '. substr($error_params, 0, -2). ' are missing or empty.'; //to remove comma, we use substr
        
        //error is encoded in json format
        $response->write(json_encode($error_detail));
    }
    return $error;
}

//http delete request
$app->delete('/deleteuser/{id}', function (Request $request, Response $response, array $args){
    $id = $args['id'];

    $db = new DbOperations;
    $response_data = array();

    if($db->deleteUser($id)){
        $response_data['error'] = false;
        $response_data['message'] = 'user has been deleted';
    }else{
        $response_data['error'] = true;
        $response_data['message'] = 'Please try again later';
    }

    $response->write(json_encode($response_data));

    return $response    
            ->withHeader('Content-type','application/json')
            ->withStatus(200);
});
$app->run();