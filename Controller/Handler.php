<?php 


class Handler 
{
    public static function HandleExeception(Throwable $e):void
    {
        http_response_code(500);
        echo json_encode([
            "code"=>$e->getCode(),
            "message"=>$e->getMessage(),
            "file"=>$e->getFile(),
            "line"=>$e-> getLine()
        ]);
    }
    public static function ErrorHandler(
        int $errno,
        string $errstr,
        string $errfile,
        int $errLine
    ):bool{

        throw new ErrorException($errstr,0,$errno,$errfile,$errLine);
        
    }
    
}




?>