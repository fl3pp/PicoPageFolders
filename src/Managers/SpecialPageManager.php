<?php

namespace PicoPageFolders\Managers;

class SpecialPageManager {
    private $config;
    private $fileSystem;

    public function __construct($config, $fileSystem) {
        $this->config = $config;
        $this->fileSystem = $fileSystem;
    }

    public function isSpecialPage($id) {
        return substr($id, 0, 5) == 'index' || substr($id, 0, 3) == '404';
    }

    public function load404(&$content, $language) {
        $contentDir = $this->config['content_dir'];
        $contentExt = $this->config['content_ext'];
        $errorFile = $contentDir.'/404/'.$language.$contentExt;
        if ($this->fileSystem->exists($errorFile)) {
            $content = $this->fileSystem->readFile($errorFile);
        }
    }
        
}