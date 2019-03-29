<?php

class PicoPageFolders extends AbstractPicoPlugin {
    const API_VERSION = 2;
    private $plugin;

    public function onConfigLoaded(&$config) {
        $this->plugin = new \PicoPageFolders\Plugin(
            $config,
            new \PicoPageFolders\Wrappers\GetWrapper(),
            new \PicoPageFolders\Wrappers\FileSystemWrapper());        
    }

    public function onRequestUrl(&$requestUrl) {
        $this->plugin->processUrl($requestUrl);
    }

    public function onSinglePageLoading($id, &$skipFile) {
        $this->plugin->processId($id);
        $skipFile = $this->plugin->skipLoading($id);
    }

    public function onPagesLoaded(&$pages) {
        $this->plugin->hidePages($pages);
    }

    public function onPageRendering(&$twigTemplate, &$twigVariables) {
        $this->plugin->setTemplateVariables($twigVariables);
    }
    
    public function on404ContentLoaded(&$rawContent) {
        $this->plugin->load404($rawContent);
    }
}
