# Yii2 SEO components

Yii2 SEO components - пакет с некоторыми полезными классами, которые предоставляют
часто используемые методы для работы с SEO-текстами и их обработки.

![SEO image](../seoimage.png)

[English documentation](../README.md)

## Класс SeoText

Обеспечивает полезные методы для обработки исходного текста и сбора статистической
информации об обрабатываемом тексте.

```php
use maxodrom\yii2seo\components\SeoText;

// инстанцируем новый объект SeoText; в конструктор передаем сам текст первым параметром
$seoText = new SeoText($model->textField);

// подсчитываем число всех слов в тексте
$totalWords =  $seoText->getWordsCount();

// подсчитываем число всех символов в тексте, включая различные пробельные символы
$totalCharacters = $seoText->getTotalCharactersCount();

// подсчет числа всех непробельных символов текста
$wordCharacters = $seoText->getCharactersCount();

// подсчет числа всех пробельных символов 
$totalSpaces = $seoText->getSpacesCount();

```
