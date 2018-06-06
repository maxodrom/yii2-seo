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
 *
 * @property string $text Source text
 * @property-read array $words Words from source text
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
        'character' => '/\S/iu',
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
     * Gets source text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets source text for processing.
     *
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
     * Gets all source text words as array.
     *
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Splits text into words.
     *
     * @param string|null $wordPattern Regex for detecting words in source text. Default is '/[\w\-]+/iu'.
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
     * Returns all text words numbers.
     *
     * @param string|null $wordPattern Regex for detecting words in source text. Default is '/[\w\-]+/iu'.
     * @return int
     * @throws \yii\base\Exception
     */
    public function getWordsCount($wordPattern = null)
    {
        return count($this->splitIntoWords($wordPattern));
    }

    /**
     * Returns total spaces number.
     *
     * @param string|null $spacePattern Regex for detecting spaces (all kinds or some of them) in source text.
     * Default regex is '/\s/u'.
     * @return int
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
     * Returns all characters count excluding all space characters.
     *
     * @param string|null $characterPattern Regex for detecting all not space characters in source text.
     * Default is '/\S/iu'.
     * @return int
     * @throws \yii\base\Exception
     * @since 1.1
     */
    public function getCharactersCount($characterPattern = null)
    {
        is_string($characterPattern) ?
            $pt = $characterPattern : $pt = self::$patterns['character'];

        $this->checkRegex($pt);

        if (false === ($count = preg_match_all($pt, $this->text, $matches))) {
            throw new Exception(preg_last_error());
        }

        return $count;
    }

    /**
     * Returns total characters including as regular characters as any space characters.
     *
     * @param null $characterPattern Regex for detecting all not space characters in source text.
     * Default is '/\S/iu'.
     * @param null $spacePattern Regex for detecting spaces (all kinds or some of them) in source text.
     * Default regex is '/\s/u'.
     * @return int
     * @throws \yii\base\Exception
     * @since 1.1
     */
    public function getTotalCharactersCount($characterPattern = null, $spacePattern = null)
    {
        $characters = $this->getCharactersCount($characterPattern);
        $spaces = $this->getSpacesCount($spacePattern);

        return $characters + $spaces;
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