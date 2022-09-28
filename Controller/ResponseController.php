<?php
class ResponseController{
  public function __call($name,$arguments)
  {
    $this->sendOutput('', array('HTTP/1.1 404 Not Found'),200);
  }
  public function sendOutput($data, $httpHeaders=array(),$status)
  {
    header_remove('Set-Cookie');
    if (is_array($httpHeaders) &&  count($httpHeaders)) {
      foreach ($httpHeaders as $httpHeader) {
        header($httpHeader);
      }
    }
    http_response_code($status);
    echo $data;
    exit;
  }
}
?>