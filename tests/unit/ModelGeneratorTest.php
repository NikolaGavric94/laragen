<?php
/**
 * Created by PhpStorm.
 * User: nikola
 * Date: 6/18/18
 * Time: 20:26
 */

namespace Nikolag\Generator\Test;


use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Nikolag\Generator\Converter\ModelConverter;
use Nikolag\Generator\Model\Model;
use Nikolag\Generator\Model\Relationship;
use Symfony\Component\Yaml\Yaml;

class ModelGeneratorTest extends TestCase
{
    /**
     * @var string
     */
    protected $storagePath;
    /**
     * @var ModelConverter
     */
    protected $modelConverter;
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var FilesystemAdapter
     */
    protected $storage;
    /**
     * @var array
     */
    protected $data;

    /**
     *
     */
    public function assertPreConditions() {
        parent::assertPreConditions();
        $this->modelConverter = $this->app->make(ModelConverter::class);
        Storage::fake('models');
        $this->storage = Storage::disk('models');
        $this->storagePath = $this->storage->path("");
        $this->model = new Model;
        $this->data = Yaml::parseFile(__DIR__ . "/../../src/model.yml");
    }

    /**
     * @return \Nikolag\Generator\Template\Template
     * @throws \Nikolag\Generator\Exception\TemplateException
     */
    public function save() {
        $template = $this->loader->load($this->model->templateName)->with($this->model);
        $template = $this->modelConverter->compile($template);
        $this->loader->save($template, $this->storagePath . "Blog.php");
        return $template;
    }

    /**
     * @throws \Nikolag\Generator\Exception\TemplateException
     */
    public function test_create_model_from_yml_file() {
        $this->model->fill($this->data);

        $this->save();

        $this->storage->assertExists('Blog.php');
    }

    /**
     * @throws \Nikolag\Generator\Exception\TemplateException
     */
    public function test_created_model_file_from_yml_file() {
        $this->model->fill($this->data);

        $template = $this->save();
        $contents = $this->storage->get('Blog.php');

        $this->assertEquals($template->get(), $contents);
    }

    /**
     * @throws \Nikolag\Generator\Exception\TemplateException
     */
    public function test_model_data_equals() {
        $this->model->fill($this->data);

        $this->assertEquals($this->model->namespace, $this->data['namespace']);
        $this->assertEquals($this->model->name, $this->data['name']);
        $this->assertTrue($this->model->timestamps, $this->data['timestamps']);
        $this->assertEquals($this->model->fillable, $this->data['fillable']);
        $this->assertEquals($this->model->dates, $this->data['dates']);
        $this->assertThat(
            $this->model->relationships,
            $this->containsOnlyInstancesOf(Relationship::class)
        );
        $this->assertCount(3, $this->model->relationships);
        $this->assertEquals($this->model->relationships[0]->name, $this->data['relationships'][0]['name']);
        $this->assertEquals($this->model->relationships[0]->model, $this->data['relationships'][0]['model']);
        $this->assertEquals($this->model->relationships[0]->type, $this->data['relationships'][0]['type']);
        $this->assertArrayNotHasKey('pivot', $this->model->relationships[0]->toArray());
        $this->assertEquals($this->model->relationships[1]->name, $this->data['relationships'][1]['name']);
        $this->assertEquals($this->model->relationships[1]->model, $this->data['relationships'][1]['model']);
        $this->assertEquals($this->model->relationships[1]->type, $this->data['relationships'][1]['type']);
        $this->assertArrayNotHasKey('pivot', $this->model->relationships[1]->toArray());
        $this->assertEquals($this->model->relationships[2]->name, $this->data['relationships'][2]['name']);
        $this->assertEquals($this->model->relationships[2]->model, $this->data['relationships'][2]['model']);
        $this->assertEquals($this->model->relationships[2]->type, $this->data['relationships'][2]['type']);
        $this->assertArrayHasKey('pivot', $this->model->relationships[2]->toArray());
    }
}