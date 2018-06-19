<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 23:53
 */

namespace Nikolag\Generator\Converter\Contract;

use Nikolag\Generator\Exception\TemplateException;
use Nikolag\Generator\Model\Pivot;
use Nikolag\Generator\Model\Relationship;


/**
 * Interface ModelConverter
 *
 * @package App\Services\Contracts
 */
interface Model extends Converter
{
    /**
     * Convert to fillable property
     *
     * @return self
     */
    public function convertToFillable();

    /**
     * Convert to dates property
     *
     * @return self
     */
    public function convertToDates();

    /**
     * Uses timestamps in a model
     *
     * @return self
     */
    public function withTimestamps();

    /**
     * Convert to relationships
     *
     * @return self
     * @throws TemplateException
     */
    public function convertToRelationships();

    /**
     * Convert relationship to pivot relationship
     *
     * @param Relationship $relationship
     *
     * @return array
     * @throws TemplateException
     */
    public function convertToPivotRelationship(Relationship $relationship);

    /**
     * Convert pivot relationship with columns
     *
     * @param Pivot $pivot
     *
     * @return string
     * @throws TemplateException
     */
    public function convertToPivotRelationshipWithColumns(Pivot $pivot);

    /**
     * Convert pivot relationship with timestamp
     *
     * @param Pivot $pivot
     *
     * @return string
     * @throws TemplateException
     */
    public function convertToPivotRelationshipWithTimestamp(Pivot $pivot);
}