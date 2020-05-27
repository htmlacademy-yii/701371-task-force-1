<?php

namespace frontend\models\forms;

use frontend\models\Task;
use yii\base\Model;

class NewTaskForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $files;
    public $address;
    public $budget;
    public $term;

    public function attributeLabels()
    {
        return [
            'name'          => 'Мне нужно',
            'description'   => 'Подробности задания',
            'category'      => 'Категория',
            'files'         => 'Файлы',
            'address'       => 'Локация',
            'budget'        => 'Бюджет',
            'term'          => 'Срок исполнения',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['category', 'budget'], 'integer'],
            [['files'], 'file', 'maxFiles' => 10],
            [['term'], 'safe'],
            [['term'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function createTask()
    {
        $model = new Task();
        $model->title = $this->name;
        $model->description = $this->description;
        $model->address = $this->address;
        $model->latitude = 0;
        $model->longitude = 0;
        $model->price = $this->budget;
        $model->deadline = $this->term;

        //if (!$model->save()) {
        //    if ($model->hasErrors('title')) {
        //        $this->addError('title', 'такое задание уже существует');
        //    }
        //    return null;
        //}
        //
        //return $model;
        return $model->save();
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(
                'uploads/'
                . $this->imageFile->baseName
                . '.'
                . $this->imageFile->extension
            );

            return true;
        } else {
            return false;
        }
    }
}