<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/16/18
 * Time: 00:12
 */

namespace Nikolag\Generator\Helper\Contract;

interface Replacer
{
    /**
     * Replace template variable
     *
     * @param string $text
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    public function replaceTemplateVariable(string $text, string $name, string $value);

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
     * @param string $text
     * @param array $data
     * @param int $numericKey
     *
     * @return string
     */
    public function replaceTemplateVariables(string $text, array $data, int $numericKey = 0);
}