<?php

use PHPUnit\Framework\TestCase;
use PicoPageFolders\Test\Integration\IntegrationTestSetup;

class IntegrationTest extends TestCase { 

    public function test_WithIndex_LoadsIndexPage() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $testee = $setup->createTestee();

        $testee->processUrl($url);

        $this->assertSame('index/de', $url);
    }

    public function test_AvailableLanguages_LoadsAvailableLanguages() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $variables = array(
            'pages' => array(
                'test/de' => array('id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de')),
                'test/en' => array('id' => 'test/en', 'url' => 'localhost/?'.rawurlencode('test/en'))
            ),
            'current_page' => array('id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de'))
        );
        $testee = $setup->createTestee();

        $testee->processUrl($url);
        $testee->processId('test/de');
        $testee->processId('test/en');
        $testee->setTemplateVariables($variables);

        $otherLanguages = $variables['other_languages'];
        $this->assertSame('localhost/?test&lang=en', $otherLanguages['en']);
    }

    public function test_skipLoading_WithOtherLanguage_ReturnsTrue() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $testee = $setup->createTestee();

        $url = 'index/de';
        $testee->processUrl($url);
        $result = $testee->skipLoading('index/en');
        
        $this->assertTrue($result);
    }

    public function test_skipLoading_WithSameLanguage_ReturnsFalse() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $testee = $setup->createTestee();

        $url = 'index/de';
        $testee->processUrl($url);
        $result = $testee->skipLoading('test/de');
        
        $this->assertFalse($result);
    }    
    
    public function test_hidePages_WithIndexand404andNormalPage_HidesSpecialPages() {
        $setup = new IntegrationTestSetup();
        $testee = $setup->createTestee();
        $pages = array(
            'test/de' => array('id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de')),
            'index/de' => array('id' => 'index/de', 'url' => 'localhost?'.rawurlencode('index/en')),
            '404/de' => array('id' => 'index/de', 'url' => 'localhost?'.rawurlencode('404/en'))
        );
        $testee = $setup->createTestee();

        $testee->hidePages($pages);
        
        $this->assertSame(1, count($pages));
    }

    public function test_load404() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $setup->Config['content_dir'] = 'C:\temp';
        $setup->Config['content_ext'] = '.md';
        $setup->Files['C:\temp/404/de.md'] = 'testcontent';
        $testee = $setup->createTestee();

        $url = 'nonexisting';
        $testee->processUrl($url);
        $content;
        $testee->load404($content);

        $this->assertSame('testcontent', $content);
    }

    public function test_setTemplateVariables_WithIndex_SetsIndex() {
        $setup = new IntegrationTestSetup();
        $setup->GetVariables['lang'] = 'de';
        $pages = array(
            'test/de' => array('id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de')),
            'index/de' => array('id' => 'index/de', 'url' => 'localhost/?'.rawurlencode('index/de')),
            '404/de' => array('id' => 'index/de', 'url' => 'localhost/?'.rawurlencode('404/en'))
        );
        $variables = array(
            'pages' => $pages,
            'current_page' => array('id' => 'test/de', 'url' => 'localhost/?'.rawurlencode('test/de'))
        );
        $testee = $setup->createTestee();

        $url = 'test/de';
        $testee->processUrl($url);
        $testee->hidePages($pages);
        $testee->setTemplateVariables($variables);
        
        $result = $variables['index_page'];
        $this->assertSame('index', $result['id']);
        $this->assertSame('localhost/?index&lang=de', $result['url']);
    }

}