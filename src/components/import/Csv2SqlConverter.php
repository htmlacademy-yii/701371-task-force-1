<?php
declare(strict_types=1);

namespace app\components\import;
use app\components\exception\ImportException;
use SplFileObject;

class Csv2SqlConverter
{
  public static function parse(string $filePath, string $outPutDirectory): void
  {
    self::checkExists($filePath);
    $splFileObject = new SplFileObject($filePath);
    self::checkExtensionAndSize($splFileObject);

    $columns = [];
    $values = [];

    // NOTE: get data from CSV into the array
    while (!$splFileObject->eof()) {
      if ($splFileObject->key() === 0) {
        $columns = $splFileObject->fgetcsv(',');
      }

      $currentLineValues = $splFileObject->fgetcsv(',');
      $valuesString = implode('", "', $currentLineValues);
      $valuesString = sprintf('("%s")', $valuesString);
      $values[] = $valuesString;

      // NOTE: write data from array into the SQL file
      $tableName = str_replace('.csv', '', basename($splFileObject->getFileName()));
      $sqlQuery = sprintf(
        "INSERT INTO `%s` (%s) \r\n VALUES \r\n %s;",
        $tableName,
        implode(', ', array_map(function($item) {
          return "`{$item}`";
        }, $columns)),
        implode(', ' . "\r\n", $values)
      );

      $outputFileName = rtrim($outPutDirectory, DIRECTORY_SEPARATOR)
        . DIRECTORY_SEPARATOR . "{$tableName}.sql";

      if (!file_put_contents($outputFileName, $sqlQuery)) {
        throw new ImportException('Can not output SQL file');
      }
    }
  }

  /**/

  private static function checkExists(string $filePath): void
  {
    if (!file_exists($filePath)) {
      throw new ImportException('File does not exists');
    }
  }

  private static function checkExtensionAndSize($splFileObject):void
  {
    if ($splFileObject->getExtension() !== 'csv') {
      throw new ImportException('Invalid file extension');
    }

    if ($splFileObject->getSize() === 0) {
      throw new ImportException('File is empty');
    }
  }
}