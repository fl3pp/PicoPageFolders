# PicoPageFolders

PicoPageFolders is a plugin for Pico which enabled MultiLanguage and organization for Pico.

This plugin features a 100% CodeCoverage (wrappers excluded), separated in Unit and Integration Tests. 

Pull Requests are welcome!

### Features
- Organize multiple languages in a folder
- URL rewriting
- Additional twig variables
- Skip loading of not needed pages
- Adjusted Index and 404 pages

### Installation
Install via composer: `composer require jflepp/picopagefolders`

### Creating multi language pages

~~~
content
|
|- 404
   |- en.md
   |- de.md
|- index
   |- en.md
   |- de.md
|- sites
   |- articles
      |- Page1
         |- de.md
         |- en.md
Pages:
- index: /
- index-de: /?lang=de
- sites/articles/Page1
- sites/articles/Page1?lang=de
~~~

### Additional variables

- `index_page` - current page
- `language` - current language
- `other_languages` - other languages available with links (key-value)
