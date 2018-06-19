<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 19:26
 */

namespace Nikolag\Generator\Helper\Contract;


interface Spacer
{
    /**
     * Create indentation for given content
     *
     * @param string $content
     * @param int $number
     *
     * @return string
     */
    public function createSpaces(string $content = "", int $number = 4);
}