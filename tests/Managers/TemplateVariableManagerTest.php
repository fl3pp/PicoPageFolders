<?php

use PHPUnit\Framework\TestCase;
use PicoPageFolders\Managers\TemplateVariableManager;

class TemplateVariableManagerTest extends TestCase {

    public function test_updateCurrentPage_WithLanguageManager_UpdatesCurrentPageThroughLanguageManager() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getLanguageAwarePage')
                    ->willReturn(array('id' => 'iamupdated'));
        $variables = array();
        $variables['current_page'] = array('id' => 'iamoold');
        $testee = new TemplateVariableManager($langManager);

        $testee->updateCurrentPage($variables);

        $this->assertSame('iamupdated', $variables['current_page']['id']);
    }

    public function test_updatePrevAndNextPages_WithLanguageManager_UpdatesNextPageThroughLanguageManager() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getLanguageAwarePage')
                    ->willReturn(array('id' => 'iamupdated'));
        $variables = array();
        $variables['next_page'] = array('id' => 'iamoold');
        $testee = new TemplateVariableManager($langManager);

        $testee->updatePrevAndNextPages($variables);

        $this->assertSame('iamupdated', $variables['next_page']['id']);
    }
    
    public function test_updatePages_WithLangManager_UpdatesPagesThroughLangManager() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getLanguageAwarePage')
                    ->willReturn(array('id' => 'iamupdated'));
        $variables = array();
        $variables['pages'] = array();
        $variables['pages']['iamold'] = array( 'id' => 'iamold' );
        $testee = new TemplateVariableManager($langManager);

        $testee->updatePages($variables);

        $this->assertSame('iamupdated', $variables['pages']['iamupdated']['id']);
    }

    public function test_addOtherLanguages_WithOtherLanguagesInLangManager_AddsOtherLanguagePages() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getAlternativeLanguagePages')
                    ->willReturn(array('de' => 'localhost/test?lang=de', 'en' => 'localhost/test?lang=en'));
        $variables = array();
        $variables['current_page'] = array('id' => 'iamoold', 'url' => 'localhost/test?lang=fr');
        $testee = new TemplateVariableManager($langManager);

        $testee->addOtherLanguages($variables);

        $this->assertSame(2,  count($variables['other_languages']));
        $this->assertSame('localhost/test?lang=de', $variables['other_languages']['de']);
        $this->assertSame('localhost/test?lang=en', $variables['other_languages']['en']);
    }

    public function test_setLanguage_LanguageSetInLangManager_SetsVariable() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getLanguage')
                    ->willReturn('de');
        $variables = array();
        $testee = new TemplateVariableManager($langManager);

        $testee->setLanguage($variables);

        $this->assertSame('de', $variables['language']);
    }

    public function test_setIndex_Null_NotSetsVariable() {
        $variables = array();
        $testee = new TemplateVariableManager($langManager);

        $testee->setIndex($variables, null);

        $this->assertFalse(isset($variables['index_page']));
    }

    public function test_setIndex_IndexPage_SetsVariable() {
        $langManager = $this->createMock(\PicoPageFolders\Managers\LanguageManager::class);
        $langManager->method('getLanguageAwarePage')
                    ->willReturn(array('id' => 'index', 'url'=> 'localhost/?lang=de'));
        $variables = array();
        $testee = new TemplateVariableManager($langManager);

        $testee->setIndex($variables, array('id' => 'iamoold', 'url' => 'localhost/index/de'));

        $this->assertSame('localhost/?lang=de', $variables['index_page']['url']);
    }

}