<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 19:57
 */

namespace Nikolag\Generator\Converter\Contract;

use Nikolag\Generator\Template\Template;

/**
 * Interface Converter
 *
 * @package App\Services\Contracts
 */
interface Converter
{
    /**
     * @return Template
     */
    public function getTemplate();

    /**
     * @param Template $template
     *
     * @return self
     */
    public function setTemplate(Template $template);

    /**
     * Convert more than one value inside attribute
     * Example:
     * ```php
     * $converter->convertFromMultipleAttributes(array(
     *     'created_at',
     *     'updated_at'
     * ))
     * ```
     * Output:
     * ```php
     * protected $dates = [
     *     'created_at',
     *     'updated_at'
     * ];
     * ```
     *
     * @param array $attr
     * @param bool $eachNewRow
     *
     * @return mixed
     */
    public function convertFromMultipleAttributes(array $attr, bool $eachNewRow = true);

    /**
     * @param Template $template
     *
     * @return Template
     */
    public function compile(Template $template);
}