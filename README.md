# PicoPageFolders

[![Latest Stable Version](https://poser.pugx.org/jflepp/picopagefolders/v/stable)](https://packagist.org/packages/jflepp/picopagefolders) [![Total Downloads](https://poser.pugx.org/jflepp/picopagefolders/downloads)](https://packagist.org/packages/jflepp/picopagefolders)

PicoPageFolders is a plugin for Pico which provides MultiLanguage support. Pages are being separated into folders, the file names are being used as their language.

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


### examples

_Display other languages_
~~~ twig
{% for lang,page in other_languages %}
    <li>{{ lang }} - <a href="{{ page }}">{{ page }}</a></li>
{% endfor %}
~~~

