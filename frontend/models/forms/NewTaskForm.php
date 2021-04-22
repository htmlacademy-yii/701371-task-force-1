<?php

namespace frontend\models\forms;

use Exception;
use frontend\models\City;
use frontend\models\Task;
use frontend\models\TaskFile;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * @note
 * for creating new task
 *
 * Class NewTaskForm
 * @package frontend\models\forms
 */
class NewTaskForm extends Model
{
    public string $name = '';
    public string $description = '';
    public string $category = '';
    public array $files = [];
    public string $address = '';
    public int $budget = 0;
    public string $term = '';

    private $taskModel;

    /**
     * @return array
     */
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

            [['name', 'description'], 'filter', 'filter' => [Html::class, 'encode']],
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @note
     * creating and saving the task
     *
     * @return bool
     * @throws Exception
     */
    public function createTask(): bool
    {
        $task = new Task();

        /** @var City $city */
        $city = City::find()
            ->where(['id' => $this->address])
            ->one();

        $coordinates = ArrayHelper::getValue(
            Yii::$app->geocoder->getCoordinates($city->title),
            'response.GeoObjectCollection.featureMember.0.GeoObject.Point.pos'
        );

        $task->title = $this->name;
        $task->description = $this->description;
        $task->address = $city->title;
        $task->latitude = stristr($coordinates, ' ', false);
        $task->longitude = stristr($coordinates, ' ', true);
        $task->price = $this->budget;
        $task->deadline = $this->term;
        $task->category_id = $this->category;
        $task->city_id = $city->id;

        $task->owner_id = Yii::$app->user->identity->getId();
        $task->status_id = Task::STATUS_NEW;

        if (!$task->save()) {
            echo $task->status_id . '<br>';
            return false;
        }

        $this->taskModel = $task;
        return true;
    }

    /**
     * @note
     * for get full name of loading file
     * and save him in the folder
     *
     * @return void
     */
    public function upload(): void
    {
        if (!$this->files) {
            return;
        }

        foreach ($this->files as $file) {
            $fileName = $file->baseName . '.' . $file->extension;

            $file->saveAs('files/' . $fileName);
            $this->writeFile($fileName);
        }
    }

    /**
     * @note
     * for saving files in table, look up method
     *
     * @param string $fileName
     */
    public function writeFile(string $fileName): void
    {
        $taskFile = new TaskFile;

        $taskFile->image_path = $fileName;
        $taskFile->task_id = $this->taskModel->id;

        $taskFile->save();
    }
}
