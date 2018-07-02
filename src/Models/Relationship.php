<?php

/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/17/18
 * Time: 01:06
 */

namespace Nikolag\Generator\Model;

class Relationship extends AbstractModel
{
    public $templateName = "model/relationship";

    /**
     * @return bool
     */
    public function hasPivot() {
        return isset($this->pivot) && !empty($this->pivot);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (is_array($name)) {
            $key = key($name);
            if ($key == 'pivot') {
                $this->data[$key] = (new Pivot())->fill($name);
            }
        } else {
            $this->data[$name] = $value;
        }
    }

    /**
     * @param $name
     *
     * @return null
     */
    public function __get($name)
    {
        if (array_has($this->data, $name)) {
            if ($name == "pivot") {
                return (new Pivot())->fill($this->data[$name]);
            }

            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}