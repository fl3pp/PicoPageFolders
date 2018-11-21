<?php

namespace PicoPageFolders;

class Plugin {
    private $config;
    private $get;
    private $fileSystem;
    private $langManager;

    public function __construct($config, $get, $fileSystem) {
        $this->$config = $config;
        $this->get = $get;
        $this->fileSystem = $fileSystem;
        $this->langManager = new \PicoPageFolders\Managers\LanguageManager();
    }
    
    public function processUrl(&$url) {
        $this->langManager->setLanguage($this->getLang());
        $url = $this->langManager->getExtendedUrlFromUrl($url);
    }

    public function processId($id) {
        $this->langManager->addAvailableLanguage(
            $this->langManager->getLanguageFromFullId($page['id']));
    }

    public function skipLoading($id) {
        return $this->langManager->getLanguageFromFullId($page['id']) != $this->language;
    }

    public function hidePages(&$pages) {
        $specialPageManager = new \PicoPageFolders\Managers\SpecialPageManager($this->config, $this->fileSystem);
        foreach ($pages as $id => $page) {
            if (!$specialPageManager->isSpecialPage($id)) return;
            unset($pages[$id]); 
        }
    }

    public function setTemplateVariables(&$variables) {
        $templateVariableManager = new \PicoPageFolders\Managers\TemplateVariableManager($this->langManager);
        $templateVariableManager->updateCurrentPage($variables);
        $templateVariableManager->updatePages($variables);
        $templateVariableManager->addOtherLanguages($variables);
    }

    private function load404(&$content) {
        $specialPageManager = new \PicoPageFolders\Managers\SpecialPageManager($this->config, $this->fileSystem);
        $specialPageManager->load404($content, $this->getLang());
    }

    private function getLang() {
        return $this->get->isDefined('lang') ? $this->get->get('lang') : 'en';
    }

}