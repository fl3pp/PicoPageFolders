<?

class PicoPageFolders extends AbstractPicoPlugin {
    private const defaultLanguage = 'en';

    public function onMetaHeaders(array &$headers) {
        $headers['language'] = 'Language';   
    }

    private $configuration;
    public function onConfigLoaded(&$config) {
        $this->configuration = $config;
    }

    private $requestFile;
    public function onRequestFile(&$requestFile) {
        $this->requestFile = $requestFile;
    }

    public function on404ContentLoaded(&$rawContent) {
        $contentDir = $this->configuration['content_dir'];
        $contentExt = $this->configuration['content_ext'];
        $errorFile = $contentDir.'/404/'.$this->language.$contentExt;
        if (file_exists($errorFile)) {
            $rawContent = file_get_contents($errorFile);
        }
    }
    
    private $language;
    public function onRequestUrl(&$requestUrl) {
        $this->language = $this->getLang();
        if (isset($requestUrl)){
            if (substr($requestUrl, -1) != '/') $requestUrl .= '/';
            $requestUrl .= $this->language;
        } else {
            $requestUrl = "index/$this->language";
        }
    }
    
    private $availableLanguages = array();
    public function onSinglePageLoading($id, &$skipFile) {
        $pageLanguage = substr($id, -2);
        if (!in_array($pageLanguage, $this->availableLanguages)) {
            array_push($this->availableLanguages, $pageLanguage);
        }
        if ($pageLanguage != $this->language) {
            $skipFile = true;
        }
    }
    
    private function updateLanguage($page) {
        $id = $page['id'];
        $langExtension = substr($id, -3);
        $newId = substr($id, 0, -strlen($langExtension));
        $page['id'] = $newId;
        $page['url'] = str_replace(rawurlencode($langExtension), '', $page['url']).'&lang='.$this->language;
        return $page;
    }

    private function createPageForOtherLang($page, $otherLang) {
        $otherPage = $page;
        $otherPage['url'] = str_replace(
            '&lang='.rawurlencode("$this->language"),
            '&lang='.rawurlencode("$otherLang"),
            $otherPage['url']);
        return $otherPage;
    }

    
    public function onPagesLoaded(&$pages) {
        foreach ($pages as $id => $page) {
            if (substr($id, 0, 5) == 'index' || substr($id, 0, 3) == '404')
                unset($pages[$id]); 
        }
    }

    public function onPageRendering(&$twigTemplate, &$twigVariables) {
        $twigVariables['current_page'] = $this->updateLanguage($twigVariables['current_page']);

        $pages = &$twigVariables['pages'];
        foreach ($pages as $id => $page) {
            unset($pages[$id]);
            $newPage = $this->updateLanguage($page);
            $pages[$newPage['id']] = $newPage;
        }

        $twigVariables['other_languages'] = array();
        foreach ($this->availableLanguages as $availableLanguage){
            if ($this->language == $availableLanguage) continue;
            $twigVariables['other_languages'][$availableLanguage] = 
                $this->createPageForOtherLang($twigVariables['current_page'], $availableLanguage);
        }
    }
    
    private function getLang() {
        return isset($_GET['lang']) ? $_GET['lang'] : 'en';
    }
}
