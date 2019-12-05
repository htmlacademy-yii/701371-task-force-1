<?php
declare(strict_types=1);

namespace app\components\import;
use app\components\exception\TaskException;
// use SplFileObject;

class CsvToSqlConverter
{
  public $fileName = null;
  // private $importFile = null;
  private $errors = false;

  public function __construct()
  {
  }

  /**/

  public function setFileName($name)
  {
    $this->fileName = './data/' . $name;
  }

  /**/

  public function getFileName()
  {
    return $this->fileName;
  }

  // /**/

  // проверяешь файл на существование
  private function checkFileExist($file): void
  {
    $this->errors = (file_exists($file)) ? false : true;
  }

  // проверяешь файл на формат
  private function checkFileExpansion($file): void
  {
    $this->errors = (pathinfo($file, PATHINFO_EXTENSION) === 'csv')
      ? false
      : true;
  }

  // проверяешь файл на пустоту
  private function checkFileContent($file): void
  {
    $this->errors = (file_get_contents($file)) ? false : true;
  }

  private function checkErrors(): void
  {
    $this->checkFileExist($this->getFileName());
    $this->checkFileExpansion($this->getFileName());
    $this->checkFileContent($this->getFileName());
  }

  // /**/

  public function beginEvent(): void
  {
    $this->checkErrors();
    // echo 'ERROR DEBUGGING: ' . $this->errors;

    if ($this->errors === false) {
      $importFile = fopen($this->getFileName(), 'r');

      // echo '<table class = admin__import-view_table cellspacing = 0>';

      while (!feof($importFile)) {
        $string = fgetcsv($importFile, 1024, ';');
        $emptyStringCheck = count($string);

        // читаешь файл построчно
        if ($emptyStringCheck > 1) {
          // echo '<tr>';
          for ($i = 1; $i < 4; $i++) {
            // echo '<td>';
            // echo $string[$i];
            // echo '</td>';
          }
        }
      } 

      // echo '</table>';
      fclose($importFile);
    } else {
      throw new TaskException('Invalid CSV');
    }
  }
}

/**
 * TODO:
 * • если номер строки = 0, то наполняешь массив полей тыблицы,
 * иначе наполняешь массив значений для вставки
 *
 * • собираешь всё в единый запрос
 */

/**
 * TODO:
 * На выходе тебе надо получить что-то подобное
 * INSERT INTO table_name (field1, field2, ...)
 * VALUES (value11, value12, ...),
 * (value21, value22, ...),
 * (value31, value32, ...),
 * (value41, value42, ...),
 * (value51, value52, ...);
 */

/**
 * используй sprintf, implode и array_map
 * printf чтобы обернуть строку значений в круглые скобки
 * mplode чтобы собрать строку вставляемых значений, разделёггых запятой
 * rray_map чтобы каждое значение заключить в одинакрные кавычки '
 * сё просто - объявляешь массив для строк вставки
 * итаешь посчтрочно файл и делаешь так:

 * разбиваешь строку в массив разделителем ;
 * пробегаешь по получившемуся массиву значений в  array_map и заключаешь каждое значение в одинакрные кавычки
 * собираешь весь массив в строку с запятой как разделителем через implode
 * оборачиваешь получившуюся строку в круглые скобки через sprintf
 * добавляешь то, что получилось в массив для строк вставки

 * oo;bar;baz

 * edited)
 * plFileObject::fgetcsv(';') => (edited)

 * "foo", "bar", "baz"]

 * edited)
 * rray_map => (edited)

 * "'foo'", "'bar'", "'baz'"]

 * mplode => (edited)

 * foo', 'bar', 'baz'

 * printf => (edited)

 * 'foo', 'bar', 'baz')
 */