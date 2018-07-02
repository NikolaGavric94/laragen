<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/17/18
 * Time: 01:13
 */

namespace Nikolag\Generator\Model;

class Pivot extends AbstractModel
{
    public $templateName = ["model/pivot/columns", "model/pivot/timestamp"];

    /**
     * @return bool
     */
    public function hasTimestamp() {
        return isset($this->timestamp) && $this->timestamp;
    }

    /**
     * @return bool
     */
    public function hasColumns() {
        return isset($this->columns) && count($this->columns) > 0;
    }

    /**
     * @param $array
     *
     * @return array
     */
    public function resolveArray($array) {
        foreach ($array as $key => $properties) {
            if (is_array($properties)) {
                $temp[$key] = $this->resolveArray($properties);
            } else {
                $temp[$key] = $properties;
            }
        }

        return $temp;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (is_array($name)) {
            $key = key($name);
            $this->data[$key] = $this->resolveArray($name);
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
        if (array_key_exists($name, $this->data)) {
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