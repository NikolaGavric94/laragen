<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/13/18
 * Time: 00:05
 */

namespace Nikolag\Generator\Template;

use Nikolag\Generator\Exception\TemplateException;
use Illuminate\Filesystem\Filesystem;
use \Exception;

/**
 * Class TemplateLoader
 *
 * @package App\Templates
 */
class TemplateLoader
{
    /**
     * @var Filesystem
     */
    private $fs;
    /**
     * @var array
     */
    private $loaded;
    /**
     * Default templates root
     *
     * @var string
     */
    protected $default = "Laravel";

    /**
     * TemplateLoader constructor.
     *
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
        $this->loaded = [$this->default];
    }

    /**
     * Load template by name
     *
     * @param string $name
     *
     * @return Template
     * @throws TemplateException
     */
    public function load(string $name)
    {
        $rootPath = __DIR__ . DIRECTORY_SEPARATOR . $this->default . DIRECTORY_SEPARATOR;

        if (!isset($this->loaded[$this->default][$name])) {
            $path = $rootPath . "{$name}.stub";
            try {
                $this->loaded[$this->default][$name] = ltrim($this->fs->get($path));
            } catch (Exception $e) {
                throw new TemplateException("Unable to read the file '{$path}'");
            }
        }

        return new Template($this->loaded[$this->default][$name]);
    }

    /**
     * Save a compiled template
     *
     * @param Template $template
     * @param string $path
     *
     * @throws TemplateException
     */
    public function save(Template $template, string $path)
    {
        try {
            $this->fs->put($path, $template->get(), true);
        } catch (Exception $e) {
            throw new TemplateException("Unable to save the file '{$path}'");
        }
    }
}