<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 19:58
 */

namespace Nikolag\Generator\Converter;

use Nikolag\Generator\Converter\Contract\Converter as IConverter;
use Nikolag\Generator\Helper\Contract\Spacer;
use Nikolag\Generator\Helper\Contract\Replacer;
use Nikolag\Generator\Template\Template;
use Nikolag\Generator\Template\TemplateLoader;


/**
 * Template variable binding Converter
 *
 * @package App\Services
 */
abstract class Converter implements IConverter
{
    /**
     * @var Spacer
     */
    protected $spacer;
    /**
     * @var Replacer
     */
    protected $replacer;
    /**
     * @var Template
     */
    protected $template;
    /**
     * @var TemplateLoader
     */
    protected $loader;

    /**
     * Converter constructor.
     *
     * @param TemplateLoader $loader
     * @param Spacer $spacer
     * @param Replacer $replacer
     */
    public function __construct(TemplateLoader $loader, Spacer $spacer, Replacer $replacer)
    {
        $this->spacer = $spacer;
        $this->replacer = $replacer;
        $this->loader = $loader;
    }

    /**
     * @inheritdoc
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @inheritdoc
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function convertFromMultipleAttributes(array $attr, bool $eachNewRow = true)
    {
        $tempAttr = array_map(function ($one) {
            return "'" . $one . "'";
        }, $attr);

        if($eachNewRow) {
            $tempAttr = implode("," . PHP_EOL, $tempAttr);
            return $this->spacer->createSpaces($tempAttr, 8);
        } else {
            $tempAttr = implode(",", $tempAttr);
            return $tempAttr;
        }
    }

    /**
     * @inheritdoc
     */
    public abstract function compile(Template $template);
}