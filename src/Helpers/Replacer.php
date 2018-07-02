<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/16/18
 * Time: 00:12
 */

namespace Nikolag\Generator\Helper;

use Nikolag\Generator\Helper\Contract\Replacer as IReplacer;
use Nikolag\Generator\Template\Template;

class Replacer implements IReplacer
{
    /**
     * @inheritdoc
     */
    public function replaceTemplateVariable(string $text, string $name, string $value)
    {
        return str_replace("{{" . $name . "}}", $value, $text);
    }

    /**
     * @inheritdoc
     */
    public function replaceTemplateVariables(string $text, array $data, int $numericKey = 0)
    {
        if (count($data) == $numericKey) {
            return $text;
        } else {
            $associativeKey = array_keys($data)[$numericKey];
            if (is_array($data[$associativeKey])) {
                return $this->replaceTemplateVariables($text, $data[$associativeKey]);
            } else {
                $text = $this->replaceTemplateVariable($text, $associativeKey, $data[$associativeKey]);
            }
            return $this->replaceTemplateVariables($text, $data, $numericKey + 1);
        }
    }
}