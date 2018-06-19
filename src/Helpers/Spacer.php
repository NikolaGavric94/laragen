<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 19:24
 */

namespace Nikolag\Generator\Helper;

use Nikolag\Generator\Helper\Contract\Spacer as ISpacer;

class Spacer implements ISpacer
{
    /**
     * @inheritdoc
     */
    public function createSpaces(string $content = "", int $number = 4)
    {
        // Separate by newlines
        $rows = explode(PHP_EOL, $content);

        // Add spaces to each row
        $rows = array_map(function($row) use ($number) {
            return str_repeat(" ", $number) . $row;
        }, $rows);

        // Merge into a string by newlines
        $rows = implode(PHP_EOL, $rows);

        // Return
        return $rows;
    }
}