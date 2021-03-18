<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/17
 * Time: 16:39
 */

namespace App\Domain;

class Label
{
    private $label_id;

    private $name;

    private function __construct($name, $label_id = null)
    {
        $this->name = $name;
        $this->label_id = $label_id;
    }
    public static function create($name)
    {
        return new Label($name);
    }
    public static function map(\App\Label $model)
    {
        return new Label($model->getAttribute("name"), $model->getKey());
    }
    public function getLabelId()
    {
        return $this->label_id;
    }
    public function getName()
    {
        return $this->name;
    }
}
