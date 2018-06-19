<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/16/18
 * Time: 00:12
 */

namespace Nikolag\Generator\Helper\Contract;


use Nikolag\Generator\Template\Template;

interface Replacer
{
    /**
     * Replace template variable
     *
     * @param Template $template
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    public function replaceTemplateVariable(Template $template, string $name, string $value);

    /**
     * Replace multiple template variables recursively.
     * Example:
     * ```php
     * $template = $templateLoader->load('model/relationship');
     * $arr = array(
     *     [
     *         'name' => 'user',
     *         'type' => 'belongsTo',
     *         'model' => 'App\User'
     *     ],
     *     [
     *         'name' => 'post',
     *         'type' => 'hasOne',
     *         'model' => 'App\Post'
     *     ]
     * );
     * $content = $converter->replaceTemplateVariables($template, $arr);
     * ```
     * Output:
     * ```php
     * public function user()
     * {
     *     return $this->belongsTo("App\User");
     * }
     * public function post()
     * {
     *     return $this->hasOne("App\Post");
     * }
     * ```
     *
     * @param Template $template
     * @param array $data
     * @param int $numericKey
     *
     * @return string
     */
    public function replaceTemplateVariables(Template $template, array $data, int $numericKey = 0);
}