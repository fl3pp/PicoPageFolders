<?php

namespace PicoPageFolders;

class Plugin {
    private $config;
    private $get;
    private $fileSystem;
    private $langManager;

    public function __construct($config, $get, $fileSystem) {        
        $this->config = $config;
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
            $this->langManager->getLanguageFromFullId($id));
    }

    public function skipLoading($id) {
        return $this->langManager->getLanguageFromFullId($id) != $this->langManager->getLanguage();
    }

    private $indexPage;
    public function hidePages(&$pages) {
        $specialPageManager = new \PicoPageFolders\Managers\SpecialPageManager($this->config, $this->fileSystem);
        foreach ($pages as $id => $page) {
            if ($specialPageManager->isIndex($id)) {
                $this->index = $page;
                unset($pages[$id]); 
            } else if ($specialPageManager->is404($id)) {
                unset($pages[$id]); 
            }
        }
    }

    public function setTemplateVariables(&$variables) {
        $templateVariableManager = new \PicoPageFolders\Managers\TemplateVariableManager($this->langManager);
        $templateVariableManager->updateCurrentPage($variables);
        $templateVariableManager->updatePrevAndNextPages($variables);
        $templateVariableManager->updatePages($variables);
        $templateVariableManager->setLanguage($variables);
        $templateVariableManager->setIndex($variables, $this->indexPage);
        $templateVariableManager->addOtherLanguages($variables);
    }

    public function load404(&$content) {
        $specialPageManager = new \PicoPageFolders\Managers\SpecialPageManager($this->config, $this->fileSystem);
        $specialPageManager->load404($content, $this->langManager->getLanguage());
    }

    private function getLang() {
        return $this->get->isDefined('lang') ? $this->get->get('lang') : 'en';
    }

}