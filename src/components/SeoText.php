<?php
/**
 * Yii2 SEO components project.
 *
 * @author Max Alexandrov <max@7u3.ru>
 * @link https://github.com/maxodrom/yii2-seo
 * @copyright Copyright (c) Max Alexandrov, 2018
 */

namespace maxodrom\yii2seo\components;

use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidArgumentException;

/**
 * Class SeoText
 * @package maxodrom\yii2seo\components
 * @since 1.0
 */
class SeoText extends Component
{
    /**
     * @var string Text as it is.
     */
    protected $text;
    /**
     * @var array Text words.
     */
    protected $words = [];
    /**
     * @var array Useful general patterns.
     */
    protected static $patterns = [
        'word' => '/[\w\-]+/iu',
        'space' => '/\s/u',
        'spaces' => '/\s+/u',
    ];


    /**
     * SeoText constructor.
     * @param string $text
     * @param array $config
     */
    public function __construct($text = '', array $config = [])
    {
        $this->setText($text);
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        if (!is_string($text)) {
            throw new InvalidArgumentException(
                '$text argument must be a valid string.'
            );
        }

        $encoding = mb_detect_encoding($text, ['UTF-8', 'ASCII', 'windows-1251']);
        if ($encoding !== 'UTF-8') {
            $text = mb_convert_encoding($text, 'UTF-8', $encoding);
        }

        $this->text = $text;

        return $this;
    }

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * @param array $words
     */
    public function setWords(array $words = [])
    {
        $this->words = $words;
    }

    /**
     * @param null $wordPattern
     * @return array[]|false|string[]
     * @throws \yii\base\Exception
     */
    public function splitIntoWords($wordPattern = null)
    {
        is_string($wordPattern) ?
            $pt = $wordPattern : $pt = self::$patterns['word'];

        $this->checkRegex($pt);

        if (false === preg_match_all($pt, $this->text, $matches)) {
            throw new Exception(preg_last_error());
        }

        return $matches[0];
    }

    /**
     * @param string|null $wordPattern
     * @return int
     * @throws \yii\base\Exception
     */
    public function getWordsCount($wordPattern = null)
    {
        return count($this->splitIntoWords($wordPattern));
    }

    /**
     * @param null $spacePattern
     * @return false|int
     * @throws \yii\base\Exception
     */
    public function getSpacesCount($spacePattern = null)
    {
        is_string($spacePattern) ?
            $pt = $spacePattern : $pt = self::$patterns['space'];

        $this->checkRegex($pt);

        if (false === ($count = preg_match_all($pt, $this->text, $matches))) {
            throw new Exception(preg_last_error());
        }

        return $count;
    }

    /**
     * @param string $regex
     * @return bool
     */
    protected function checkRegex($regex)
    {
        if (false === preg_match($regex, '')) {
            throw new InvalidArgumentException(
                'Invalid pattern: "' . $regex . '"'
            );
        }

        return true;
    }
}