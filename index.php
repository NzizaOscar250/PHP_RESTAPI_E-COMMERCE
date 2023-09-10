<?php 
declare(strict_types=1);


spl_autoload_register(function ($class_name) {

$filePath="Controller/".$class_name . '.php';
    // print_r($filePath);
    if(file_exists($filePath)){
        require_once($filePath);

    }
  


});
set_error_handler("Handler::ErrorHandler");
set_exception_handler("Handler::HandleExeception");
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json; charset=UTF-8");








$parts = explode("/",$_SERVER['REQUEST_URI']);
$parts = array_values(array_filter($parts));

if($parts[1] != 'products'){
    http_response_code(404);
    exit;
}


$id = $parts[2]  ?? null;
$database = new Db("localhost","root","","test");
 $gateway = new ProductGateWay($database);
 $controller = new ProductController($gateway) ;


switch ($parts[1]) {
    case 'products':
   
        $controller->processRequest($_SERVER['REQUEST_METHOD'],$id);
        break;
    
    default:
        # code...
        break;
}
?>