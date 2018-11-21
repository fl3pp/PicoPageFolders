<?php

namespace PicoPageFolders\Wrappers;

/**
 * @codeCoverageIgnore
 */
class FileSystemWrapper {
    public function readFile($path) {
        return file_get_contents($path);
    }
}