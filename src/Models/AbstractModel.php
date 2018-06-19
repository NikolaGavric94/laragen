<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/18/18
 * Time: 23:35
 */

namespace Nikolag\Generator\Model;

use Nikolag\Generator\Model\Contract\Clazz;

abstract class AbstractModel implements Clazz
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Illuminate\Database\Eloquent\JsonEncodingException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function($curr) {
            return $curr ?? [];
        }, $this->data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}