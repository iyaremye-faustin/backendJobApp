<?php
namespace MyApp\Traits;
trait Response
{
    public function __call($name, $arguments)
    {
        $this->sendOutput("", ["HTTP/1.1 404 Not Found"], 404);
    }

    public function successResponse($data,$status,$httpHeaders = [])
    {
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        http_response_code($status);
        echo json_encode($data);
    }

    public function errorResponse($error,$status, $httpHeaders = [])
    {
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        http_response_code($status);
        echo json_encode($error);
    }
}
?>
