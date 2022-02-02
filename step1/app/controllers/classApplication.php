<?php

class classApplication
{
    static $instance;
    public $message;
    public $word;
    public $wordReversed;
    public $pattern;
    public $response;

    public static function getInstance()
    {
        if (!self::$instance instanceof classApplication) {
            self::$instance = new classApplication();
        }

        return self::$instance;
    }

    public function initApp($word){
        $this->word         = $word;
        $this->wordReversed = strrev($word);
        $this->pattern      = '/^[a-zA-Z0-9]+$/';

        $this->message      = "inizio controlli | Parola inserita: ".$this->word; 
        $this->log();
    }

    public function checkLength(){
        if(strlen($this->word) < 3){
            $this->message =  "Il campo deve contenere almeno 3 caratteri";
            $this->log();
    
            $this->response = array(
                "valid" => false, 
                "type" => "lenght", 
                "message" => (string) null
            );
            $this->sendResponse();
        }
    }

    public function checkRegxp(){
        if(!preg_match($this->pattern, $this->word, $matches)){
            $this->message =   "Il campo può contenere solamente caratteri alfanumerici";
            $this->log();

            $this->response = array(
                "valid" => false, 
                "type" => "regx", 
                "message" => (string) null
            );
            $this->sendResponse();
        }
    }

    public function checkPalindrom(){
        if(strtolower(str_replace(" ", "", $this->word)) == strtolower(str_replace(" ", "", $this->wordReversed))){
            $this->message = "La parola ".$this->word." è palindroma"; 
            $this->log();
            
            $this->response = array(
                "valid"     => true, 
                "type"      => "check", 
                "message"   => "EVVIVA, la parola <b>".$this->word."</b> &egrave; palindroma"
            );
            $this->sendResponse();
        }else{
            $this->message = "La parola ".$this->word." non è palindroma"; 
            $this->log();
            
            $this->response = array(
                "valid"     => false, 
                "type"      => "check", 
                "message"   => "La parola ".$this->word." non &egrave; palindroma"
            );
            $this->sendResponse();
        }
    }

    public function log(){
        file_put_contents(
            logpath . date("Y-m-d") . "-" . enviroment . ".log",
            "[" . date("Y-m-d H:i:s") . "] ".$this->message." \n",
            FILE_APPEND
        );
    }

    public function sendResponse($code = 200){
        $this->message      = "fine controlli"; 
        $this->log();

        http_response_code($code);
        die(json_encode($this->response));
    }
}