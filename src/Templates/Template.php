<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/13/18
 * Time: 00:05
 */

namespace Nikolag\Generator\Template;

use Nikolag\Generator\Model\Contract\Clazz as IClass;
use Nikolag\Generator\Helper\Replacer;
use \stdClass;

/**
 * Class Template
 *
 * @package App\Templates
 */
class Template
{
    /**
     * @var TemplateLoader
     */
    protected $loader;
    /**
     * @var string
     */
    protected $content;
    /**
     * @var string
     */
    protected $compiled;
    /**
     * @var IClass
     */
    protected $data;
    /**
     * @var bool
     */
    protected $dirty;

    /**
     * Template constructor.
     *
     * @param TemplateLoader $loader
     * @param string $content
     */
    public function __construct(TemplateLoader $loader, string $content)
    {
        $this->loader = $loader;
        $this->content = $content;
        $this->compiled = $content;
        $this->data = new stdClass();
        $this->dirty = false;
    }

    /**
     * Is this template changed
     *
     * @return bool
     */
    public function isDirty() {
        return $this->dirty;
    }

    /**
     * Clean this template
     *
     * @return $this
     */
    public function clean()
    {
        $this->data = [];
        $this->dirty = false;

        return $this;
    }

    /**
     * Get part of data
     *
     * @param string $name
     *
     * @return string
     */
    public function getData(string $name) {
        return $this->hasData($name) ? $this->data->{$name} : "";
    }

    /**
     * Does data already exist?
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasData(string $name) {
        return isset($this->data, $name) && !is_null($this->data->{$name});
    }

    /**
     * Convertible template data
     *
     * @param IClass $data
     *
     * @return $this
     */
    public function with(IClass $data)
    {
        if ($data)
            $this->dirty = true;
        $this->data = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompiled() {
        return $this->compiled;
    }

    /**
     * @param string $compiled
     */
    public function setCompiled(string $compiled) {
        $this->compiled = $compiled;
    }

    /**
     * Retrieve template
     *
     * @return string
     */
    public function get()
    {
        if ($this->dirty) {
            $this->compile();
            $this->dirty = false;
        }

        return $this->compiled;
    }

    /**
     * Compile template
     *
     * @return $this
     */
    public function compile()
    {
        $replacer = new Replacer();

        $this->compiled = $replacer->replaceTemplateVariables($this, $this->data->toArray());

        return $this;
    }
}