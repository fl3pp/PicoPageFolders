<?php

use PHPUnit\Framework\TestCase;
use PicoPageFolders\Managers\LanguageManager;

class LanguageManagerTest extends TestCase {

    public function test_getLanguage_LanguageSetBefore_ReturnsLanguage() {
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $result = $testee->getLanguage();
        
        $this->assertSame('de', $result);
    }

    public function test_getLanguageFromFullId_WithFullId_ReturnsLast2Chars() {
        $testee = new LanguageManager();

        $result = $testee->getLanguageFromFullId('test/de');

        $this->assertSame('de', $result);
    }

    public function test_getAlternativeLanguagePages_AlternativeLanguagesExist_ReturnOtherPages() {
        $page = array('id' => 'test', 'url' => 'http://localhost/?test&lang=de' );
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $testee->addAvailableLanguage('en');
        $testee->addAvailableLanguage('fr');
        $testee->addAvailableLanguage('de');
        $result = $testee->getAlternativeLanguagePages($page);

        $this->assertSame(2, count($result));
        $this->assertSame('http://localhost/?test&lang=en', $result['en']);
        $this->assertSame('http://localhost/?test&lang=fr', $result['fr']);
    }
    
    public function test_getLanguageAwarePage_WithDefaultPage_ReturnNewIdAndUrl() {
        $inputPage = array( 'id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de') );
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $result = $testee->getLanguageAwarePage($inputPage);

        $this->assertSame('test', $result['id']);
        $this->assertSame('localhost/?test&lang=de', $result['url']);
    }
    

    public function test_getExtendedUrlFromUrl_WithDefaultUrl_ExtendsUrlWithLanguageFile() {
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $result = $testee->getExtendedUrlFromUrl('test');

        $this->assertSame('test/de', $result);
    }


    public function test_getExtendedUrlFromUrl_UrlWithEndingSlash_ExtendsUrlWithLanguageFile() {
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $result = $testee->getExtendedUrlFromUrl('test/');

        $this->assertSame('test/de', $result);
    }

    public function test_getExtendedUrlFromUrl_WithNull_ReturnsIndex() {
        $testee = new LanguageManager();

        $testee->setLanguage('de');
        $result = $testee->getExtendedUrlFromUrl(null);

        $this->assertSame('index/de', $result);
    }
}