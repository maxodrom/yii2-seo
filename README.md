# Yii2 SEO components

Yii2 SEO components is a package with some useful classes which are 
provided with frequently used methods to work with and processing SEO texts. 

![SEO image](./seoimage.png)

[Русская документация](docs/README.ru.md)

## SeoText class

Provides useful methods for source text processing and gathering statistical info
about processed text.

```php
use maxodrom\yii2seo\components\SeoText;

// instantiate new SeoText object
$seoText = new SeoText($model->textField);

// get total words in our text
$totalWords =  $seoText->getWordsCount();

// get total characters count (including different spaces chars)
$totalCharacters = $seoText->getTotalCharactersCount();

// get only word's characters count
$wordCharacters = $seoText->getCharactersCount();

// get all spaces count 
$totalSpaces = $seoText->getSpacesCount();

```
