<?php

namespace frontend\models\forms;

use frontend\models\City;
use frontend\models\Task;
use frontend\models\TaskFile;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class NewTaskForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $files;
    public $address;
    public $budget;
    public $term;

    private $taskModel;

    public function attributeLabels(): array
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'term' => 'Срок исполнения',
        ];
    }

    public function rules(): array
    {
        return [
            [['name', 'description', 'category'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['category', 'budget'], 'integer'],
            [['term', 'files'], 'safe'],
            [['files'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, webp', 'maxFiles' => 10],
            [['term'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @return Task
     */
    public function createTask()
    {
        $task = new Task();
        $city = City::find()
            ->where(['id' => $this->address])
            ->one();

        $coordinates = ArrayHelper::getValue(
            Yii::$app->geocoder->getCoordinates($city->title),
            'response.GeoObjectCollection.featureMember.0.GeoObject.Point.pos'
        );

        $task->title = $this->name;
        $task->description = $this->description;

        // TODO: remember sansey about TQ
        $task->address = $city->title;
        $task->latitude = stristr($coordinates, ' ', true);;
        $task->longitude = stristr($coordinates, ' ', false);;
        $task->price = $this->budget;
        $task->deadline = $this->term;
        $task->category_id = $this->category;
        $task->city_id = $city->id;

        // FIXME: fix it when the task requires it
        $task->executor_id = 1;
        $task->owner_id = 1;
        $task->status_id = 1;
        //$task->validate();

        if (!$task->save()) {
            return false;
        }

        $this->taskModel = $task;
        return true;
    }

    /**
     * @param UploadedFile $files
     * @return bool
     */
    public function upload()
    {
        if (!$this->files) {
            return false;
        }

        foreach ($this->files as $file) {
            $fileName = $file->baseName . '.' . $file->extension;

            $file->saveAs('files/' . $fileName);
            $this->writeFile($fileName);
        }
    }

    public function writeFile($fileName)
    {
        $taskFile = new TaskFile;

        $taskFile->image_path = $fileName;
        $taskFile->task_id = $this->taskModel->id;

        $taskFile->save();
    }
}
