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
use yii\base\InvalidArgumentException;

/**
 * Class SeoText
 * @package app\components\common
 */
class SeoText extends Component
{
    /**
     * @var string
     */
    protected $text;


    /**
     * SeoText constructor.
     * @param string $text
     * @param array $config
     */
    public function __construct($text, array $config = [])
    {
        if (!is_string($text)) {
            throw new InvalidArgumentException(
                '$text param must be a valid string.'
            );
        }
        parent::__construct($config);
    }


}