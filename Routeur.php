<?php
class Routeur{
    public $base_url;
    public $histories;
    public function __construct()
    {
        $this->base_url="http://127.0.0.1:8000/";
        $this->histories=[];
    }
    public function goto($dest){
        array_push($this->histories,$dest);
        header("Location:".$dest.".php");
        die();
    }
}