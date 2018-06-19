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
    public function replaceTemplateVariable(Template $template, string $name, string $value)
    {
        return str_replace("{{" . $name . "}}", $value, $template->getCompiled());
    }

    /**
     * @inheritdoc
     */
    public function replaceTemplateVariables(Template $template, array $data, int $numericKey = 0)
    {
        if (count($data) == $numericKey) {
            return $template->getCompiled();
        } else {
            $associativeKey = array_keys($data)[$numericKey];
            if (is_array($data[$associativeKey])) {
                return $this->replaceTemplateVariables($template, $data[$associativeKey]);
            } else {
                $template->setCompiled($this->replaceTemplateVariable($template, $associativeKey, $data[$associativeKey]));
            }
            return $this->replaceTemplateVariables($template, $data, $numericKey + 1);
        }
    }
}