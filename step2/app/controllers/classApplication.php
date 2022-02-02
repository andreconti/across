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

    public function checkToken(){
        if (preg_match('/(['.token.']{2,})/i', $this->word)) {
            $this->message = $this->word." | L'input non rispetta i requisiti richiesti";
            $this->log();

            $this->response = array(
                "valid" => false, 
                "type" => "check", 
                "message" => (string) null
            );
            $this->sendResponse();
        }
    }

    public function checkPalindrom(){
        if(strpos($this->word, token) > 0)
        {
            $explodeWord = explode(token, $this->word);
            foreach($explodeWord as $pieceWord)
            {
                if(strlen(trim($pieceWord)) <= 1 || empty(trim($pieceWord))){
                    $this->message = "$pieceWord | L'input non rispetta i requisiti richiesti";

                    $this->response = array(
                            "valid"     => false, 
                            "type"      => "check", 
                            "message"   => "L'input non rispetta i requisiti richiesti"
                    );
                    $this->sendResponse();
                }

                $wordReversed       = strrev($pieceWord);

                if(strtolower(str_replace(" ", "", $pieceWord)) == strtolower(str_replace(" ", "", $wordReversed))){
                    $this->message = "La parola $pieceWord è palindroma";
                    $this->log();
                }

                $this->response = array(
                        "valid"     => true, 
                        "type"      => "check", 
                        "message"   => "Controllo eseguito con successo"
                );
            }
        }else{
            $this->message = $this->word." | L'input non rispetta i requisiti richiesti";
    
            $this->response = array(
                    "valid"     => false, 
                    "type"      => "check", 
                    "message"   => "L'input non rispetta i requisiti richiesti"
            );
        }

        $this->sendResponse();
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