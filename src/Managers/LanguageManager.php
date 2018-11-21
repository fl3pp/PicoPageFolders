<?php

namespace PicoPageFolders\Managers;

class LanguageManager {
    private $currentLang;
    private $availableLanguages = array();
    
    public function setLanguage($language) {
        $this->currentLang = $language;
    }

    public function addAvailableLanguage($lanugage) {
        if (in_array($lanugage, $this->availableLanguages)) return;
        array_push($this->availableLanguages, $lanugage);
    }

    public function getLanguageFromFullId($id) {
        return substr($id, -2);
    }

    public function getAlternativeLanguagePages($page) {
        $otherLanguages = array();        
        foreach ($this->availableLanguages as $availableLanguage) {
            if ($this->currentLang == $availableLanguage) continue;
            $otherPage = $page;
            $otherPage['url'] = str_replace(
                "&lang=$this->currentLang",
                "&lang=$availableLanguage",
                $otherPage['url']);
            $otherLanguages[$availableLanguage] = $otherPage;
        }
        return $otherLanguages;
    }

    public function getLanguageAwarePage($page) {
        $id = $page['id'];
        $langExtension = substr($id, -3);
        $newId = substr($id, 0, -strlen($langExtension));
        $page['id'] = $newId;
        $page['url'] = str_replace(rawurlencode($langExtension), '', $page['url']).'&lang='.$this->currentLang;
        return $page;
    }

    public function getExtendedUrlFromUrl($url) {
        if (!isset($url))  return "index/$this->currentLang";
        if (substr($url, -1) != '/') $url .= '/';
        $url .= $this->currentLang;
        return $url;
    }
}