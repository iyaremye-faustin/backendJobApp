<?php
namespace MyApp\Routes;
use MyApp\Traits\Response;

class Router
{
    use Response;
    private $url = [];
    private $method = [];

    public function add($url, $method = null)
    {
        $this->url[] = trim($url, "/");
        if ($method != null) {
            $this->method[] = $method;
        }
    }

    public function run()
    {
        $uriGetParams = isset($_REQUEST["uri"]) ? $_REQUEST["uri"] : "/";
        foreach ($this->url as $key => $value) {
            if (preg_match("#^$value$#", $uriGetParams)) {
                return call_user_func($this->method[$key]);
            }
        }
        return $this->errorResponse(
            [
                "status" => false,
                "error" => "Not Found",
                "code" => 404,
            ],
            ["Content-Type: application/json", "HTTP/1.1 404 OK"],
            404
        );
    }
}
