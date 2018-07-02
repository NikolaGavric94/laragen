<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/13/18
 * Time: 00:05
 */

namespace Nikolag\Generator\Template;

use Nikolag\Generator\Helper\Replacer;

/**
 * Class Template
 *
 * @package App\Templates
 */
class Template
{
    /**
     * @var string
     */
    protected $text;
    /**
     * @var string
     */
    protected $compiled;
    /**
     * @var array
     */
    protected $data;
    /**
     * @var bool
     */
    protected $dirty;

    /**
     * Template constructor.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->compiled = $text;
        $this->data = [];
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
        $this->compiled = $this->text;

        return $this;
    }

    /**
     * Get part of data or all data
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getData(string $name = 'all') {
        if ($name == 'all')
            return $this->data;

        return $this->data[$name];
    }

    /**
     * Does data already exist?
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasData(string $name) {
        return array_key_exists($name, $this->data) && !is_null($this->data[$name]);
    }

    /**
     * Convertible template data
     *
     * @param array $data
     *
     * @return $this
     */
    public function with(array $data = [])
    {
        if ($data)
            $this->dirty = true;
        $this->data = $data;

        return $this;
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

        $this->compiled = $replacer->replaceTemplateVariables($this->compiled, $this->data);

        return $this;
    }
}