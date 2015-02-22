<?php
namespace Lavender\Support;

use Illuminate\Queue\SerializesModels;
use Lavender\Contracts\Workflow as WorkflowContract;

abstract class Workflow implements WorkflowContract
{

    use SerializesModels;

    public $fields = [];

    public $template = 'workflow.form';

    public $options = [];


    /**
     * Create a new workflow instance.
     */
    abstract public function __construct($params);


    /**
     * Add a field to the workflow
     *
     * @param $field
     * @param array $data
     */
    public function addField($field, array $data)
    {
        $this->fields[$field] = $this->prepareField($data);
    }


    /**
     * Get data from an existing field.
     *
     * @param string $field
     * @param string $key
     * @return mixed
     */
    public function getFieldData($field, $key)
    {
        return $this->fields[$field][$key];
    }


    /**
     * Add data to existing field.
     *
     * @param string $field
     * @param string $key
     * @param mixed $value
     */
    public function setFieldData($field, $key, $value)
    {
        $this->fields[$field][$key] = $value;
    }


    /**
     * Merge field defaults
     *
     * @param array $data
     * @return array
     */
    protected function prepareField(array $data)
    {
        return array_merge([

            /** Rendering config */
            'default' => '',
            'position' => 0,

            /** Handler config */
            'flash' => true, // which fields to flash into session
            'validate' => [], // field validation rules

            /** HTML config */
            'label' => null, // html label
            'label_options' => [], // label options
            'comment' => null, // string comment

            /** Field config */
            'type' => 'text', // type alias
            'name' => null, // field name
            'value' => null, // field value
            'options' => ['id' => null], // field options
            'resource' => null,

        ], $data);
    }


    /**
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
//    public function __call($method, $args)
//    {
//        if($field = isset($args[0]) ? $args[0] : false){
//
//            $key = snake_case(substr($method, 3));
//
//            switch(substr($method, 0, 3)){
//
//                case 'get' :
//
//                    return $this->getFieldData($field, $key);
//
//                case 'set' :
//
//                    $value = isset($args[1]) ? $args[1] : null;
//
//                    $this->setFieldData($field, $key, $value);
//
//                    return true;
//
//            }
//
//        }
//
//        throw new \Exception("Undefined method {$method}.");
//    }


}
