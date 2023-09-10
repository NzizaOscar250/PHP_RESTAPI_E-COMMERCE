<?php
// namespace Controller;

class ProductController 
{    
    private $data;
    public function __construct( ProductGateWay $gateway){
        $this->data = $gateway;
        // print_r($gateway->getAll());
    }
    public function processRequest(string $method,?string $id):void
    {  
        if($id){
            $this->processResourceRequest($method,$id);
        }
        else{
            $this->processCollectionRequest($method);
        }
    }

    public function processResourceRequest (string $method,string $id):void{

            switch ($method) {
                case 'GET':
                     echo json_encode($this->data->getProduct($id));
                    break;
                case 'DELETE':
                     echo json_encode(["message"=>$this->data->deleteProduct($id)]);
                    break;
                case 'PUT':
                    $data = (array) file_get_contents("php://input");
                    $errors = $this->getValidationError($data);
                    if(!empty($errors)){
                        http_response_code(422);
                        echo json_encode($errors);
                    break;
                    }
                    echo json_encode(["message"=>$this->data->updateProduct($id,$data)]);
                break;
                default:
                http_response_code(405);
                    header("allow: GET,PUT,DELETE");
                    echo json_encode(['message'=>"INVALID REQUEST METHOD NOT ALLOWED"]);
                    
            }

    }
    public function processCollectionRequest (string $method):void{
        switch($method){
            case 'GET':
                echo json_encode($this->data->getAll());
            break;
            case 'POST':
                $data = (array) json_decode(file_get_contents("php://input"),true);
                
                $errors = $this->getValidationError($data);
                if(!empty($errors)){
                    http_response_code(422);
                    echo json_encode($errors);

                break;
                }
                $id = $this->data->createProduct($data);
                echo json_encode([
                    "message"=>"successfully Created",
                    "id"=>$id
                ]);
             break;

             
            default:
              http_response_code(405);
              header("allow: POST,GET");
              echo json_encode(['message'=>"INVALID REQUEST METHOD NOT ALLOWED"]);
                    
        }
    }

    public function getValidationError(array $data):array
    {
        $errors = array();
        if(empty($data['name'])){
            $errors ['name']= "names are required";
        }
        if(empty($data['price'])){
                $errors['price'] = "price is required";
        }
        if(array_key_exists("price",$data)){
            if(filter_var($data['price'],FILTER_VALIDATE_INT) === FALSE){
                $errors['price'] = "invalid price";
            }
        }
        if(empty($data['slug'])){
            $data['slug'] = "Invalid Slug";
        }

        return $errors;
    }
    
    
}


?>