<?php

namespace PicoPageFolders\Wrappers;

/**
 * @codeCoverageIgnore
 */
class FileSystemWrapper {

    public function exists($path) {
        return file_exists($path);
    }
    
    public function readFile($path) {
        return file_get_contents($path);
    }
}