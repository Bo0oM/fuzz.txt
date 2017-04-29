<?php
namespace SystemFailure;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;

class SiteChecker
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function run($file)
    {
        $obj = new \SplFileObject($file);
        foreach ($obj as $string) {
            $log = new Logger($this->url);
            $log->pushHandler(new StreamHandler("logs/SiteChecker/$this->url.log", Logger::DEBUG));
            $url = trim($this->url . '/' . $string);
            $client = new \GuzzleHttp\Client();
            try {
                $res = $client->get($url);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            $statusCode = $res->getStatusCode();
            if($statusCode == '200'){
                echo "Нашли: $this->url/$string";
                $log->warning("Нашли файл $this->url/$string");
            }
        }
    }
}