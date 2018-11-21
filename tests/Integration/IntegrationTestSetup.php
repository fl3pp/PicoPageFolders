<?php

namespace PicoPageFolders\Test\Integration;

class IntegrationTestSetup {
    public $Config = array();
    
    public function createTestee() {
        return new \PicoPageFolders\Plugin(
            $this->Config,
            $this,
            $this
        );
    }
    
    /* FileSystem */
    public $Files = array();
    public function exists($path) {
        return isset($this->Files[$path]);
    }
    
    public function readFile($path) {
        return $this->Files[$path];
    }

    /* Get */
    public $GetVariables = array();
    public function get($variable) {
        return $this->GetVariables[$variable];
    }
    
    public function isDefined($variable) {
        return isset($this->GetVariables[$variable]);
    }
    
}

