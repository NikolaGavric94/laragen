<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/12/18
 * Time: 23:55
 */

namespace Nikolag\Generator\Converter;

use Nikolag\Generator\Converter\Contract\Model as IModel;
use Nikolag\Generator\Model\Pivot;
use Nikolag\Generator\Model\Relationship;
use Nikolag\Generator\Template\Template;

/**
 * Class ModelConverter
 *
 * @package App\Converters
 */
class ModelConverter extends Converter implements IModel
{
    /**
     * @inheritdoc
     */
    public function convertToFillable()
    {
        $fillableData = $this->template->hasData('fillable') ? $this->template->getData('fillable') : [];

        $tempFillable = $this->convertFromMultipleAttributes($fillableData);

        $dataArr = array_merge(
            $this->template->getData(),
            ['fillable' => $tempFillable]
        );

        $this->template->with($dataArr)->get();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function convertToDates()
    {
        $datesData = $this->template->hasData('dates') ? $this->template->getData('dates') : [];

        $tempDates = $this->convertFromMultipleAttributes($datesData);

        $dataArr = array_merge(
            $this->template->getData(),
            ['dates' => $tempDates]
        );

        $this->template->with($dataArr)->get();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withTimestamps()
    {
        $withTimestamps = $this->template->hasData('timestamps') ? $this->template->getData('timestamps') : false;

        $tempTimestamps = $withTimestamps ? "true" : "false";

        $dataArr = array_merge(
            $this->template->getData(),
            ['timestamps' => $tempTimestamps]
        );

        $this->template->with($dataArr)->get();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function convertToRelationships() {
        $____hello = "Test";
        $relationshipData = $this->template->hasData('relationships') ? $this->template->getData('relationships') : [];
        $tempRelationships = $relationshipData;
        $compiledRelationships = "";

        if (!empty($relationshipData)) {
            $lastElement = array_pop($tempRelationships);
            array_push($tempRelationships, $lastElement);

            $compiledRelationships = array_map(function (array $relation) use ($lastElement) {
                $relation = (new Relationship())->fill($relation);
                $relationshipTemplate = $this->loader->load($relation->templateName);

                $tempRelation = array_merge(
                    $this->convertToPivotRelationship($relation),
                    $relation->toArray()
                );

                $newLine = ($lastElement != $relation) ? PHP_EOL : '';

                return $relationshipTemplate->with($tempRelation)->get() . $newLine;
            }, $tempRelationships);

            $compiledRelationships = implode(PHP_EOL, $compiledRelationships);

            $compiledRelationships = PHP_EOL . $compiledRelationships;
        }

        $dataArr = array_merge(
            $this->template->getData(),
            ['relationships' => $compiledRelationships]
        );

        $this->template->with($dataArr)->get();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function convertToPivotRelationship(Relationship $relationship)
    {
        $pivotContent = [
            "timestamp" => "",
            "columns" => ""
        ];

        if ($relationship->hasPivot()) {
            $pivotContent["timestamp"] = $this->convertToPivotRelationshipWithTimestamp($relationship->pivot);
            $pivotContent["columns"] = $this->convertToPivotRelationshipWithColumns($relationship->pivot);
        }

        return $pivotContent;
    }

    /**
     * @inheritdoc
     */
    public function convertToPivotRelationshipWithColumns(Pivot $pivot)
    {
        if ($pivot->hasColumns()) {
            $template = $this->loader->load($pivot->templateName[0]);
            $tempColumns = $this->convertFromMultipleAttributes($pivot->columns, false);
            return $template->with(['columns' => $tempColumns])->get();
        }

        return "";
    }

    /**
     * @inheritdoc
     */
    public function convertToPivotRelationshipWithTimestamp(Pivot $pivot)
    {
        if ($pivot->hasTimestamp()) {
            $template = $this->loader->load($pivot->templateName[1]);
            return $template->get();
        }

        return "";
    }

    /**
     * @inheritdoc
     */
    public function compile(Template $template)
    {
        return $this->setTemplate($template)
            ->convertToFillable()
            ->convertToDates()
            ->withTimestamps()
            ->convertToRelationships()
            ->getTemplate();
    }
}