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

    private function load404(&$content) {
        $contentDir = $this->configuration['content_dir'];
        $contentExt = $this->configuration['content_ext'];
        $errorFile = $contentDir.'/404/'.$this->language.$contentExt;
        if (file_exists($errorFile)) {
            $content = file_get_contents($errorFile);
        }
    }
        
}