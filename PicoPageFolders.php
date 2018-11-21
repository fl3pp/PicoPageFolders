<?

class PicoPageFolders extends AbstractPicoPlugin {
    private const defaultLanguage = 'en';

    public function onMetaHeaders(array &$headers) {
        $headers['language'] = 'Language';   
    }


    public function onRequestUrl($requestUrl) {
        
    }

    
    
    
}