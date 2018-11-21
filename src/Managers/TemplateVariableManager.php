<?php

namespace PicoPageFolders\Managers;

class TemplateVariableManager {
    private $langManager;

    public function __construct($langManager) {
        $this->langManager = $langManager;
    }
    
    public function updateCurrentPage(&$variables) {
        $variables['current_page'] = $this->langManager->getLanguageAwarePage($variables['current_page']);
    }

    public function updatePages(&$variables) {
        $pages = &$variables['pages'];
        foreach ($pages as $id => $page) {
            unset($pages[$id]);
            $newPage = $this->langManager->getLanguageAwarePage($page);
            $pages[$newPage['id']] = $newPage;
        }
    }

    public function addOtherLanguages(&$variables) {
        $variables['other_languages'] = array();
        $otherLanguagePages = $this->langManager->getAlternativeLanguagePages($variables['current_page']);
        foreach ($otherLanguagePages as $otherLanguage => $otherLanguagePage) {
            $variables['other_languages'][$otherLanguage] = $otherLanguagePage;
        }
    }
    

}