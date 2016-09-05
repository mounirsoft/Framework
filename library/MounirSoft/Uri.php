<?php

namespace MounirSoft;

class Uri implements IUri {
    
    private $explodedURI;
    private $scriptPath;
    private $cleanedURI;
    
    public function __construct($uri) {
        $this->explodedURI = explode('/', $uri);
        $this->scriptPath = explode('/', $_SERVER['SCRIPT_NAME']);
        
        $this->cleanRequestURI();
        $this->setCleanedURI();
    }
    
    public function getCleanedURI() {
        return $this->cleanedURI;
    }
    
    private function cleanRequestURI() {
        for ($i = 0; $i < sizeof($this->scriptPath); $i++) {
            if ($this->explodedURI[$i] == $this->scriptPath[$i]) {
                unset($this->explodedURI[$i]);
            }
        }
        $this->explodedURI = array_values($this->explodedURI);
    }
    
    private function setCleanedURI() {
        $this->cleanedURI = implode('/', $this->explodedURI);
    }
    
}