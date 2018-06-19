<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/17/18
 * Time: 00:05
 */

namespace Nikolag\Generator\Model;

class Model extends AbstractModel
{
    /**
     * @var string
     */
    public $templateName = "model";

    /**
     * @param array $data
     */
    public function fill(array $data)
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (is_array($name)) {
            $key = key($name);
            if ($key == 'relationships') {
                $this->data[$key][] = new Relationship($name);
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
        if (array_key_exists($name, $this->data)) {
            if ($name == "relationships") {
                $toRet = [];

                if (!is_null($this->data[$name])) {
                    foreach ($this->data[$name] as $one) {
                        $toRet[] = new Relationship($one);
                    }
                }

                return $toRet;
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