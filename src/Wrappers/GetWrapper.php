<?php

namespace PicoPageFolders\Wrappers;

/**
 * @codeCoverageIgnore
 */
class GetWrapper {

    public function get($variable) {
        return $_GET[$variable];
    }
    
    public function isDefined($variable) {
        return isset($_GET[$variable]);
    }
}