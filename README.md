# PicoPageFolders

PicoPageFolders is a plugin for Pico which enabled MultiLanguage and organization for Pico.

### Features
- Organize multiple languages in a folder
- URL rewriting
- Additional twig variables
- Skip loading of not needed pages
- 100% CodeCoverage (without wrappers)
- Adjusted Index and 404 pages

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
