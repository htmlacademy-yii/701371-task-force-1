<?php
declare(strict_types=1);

namespace TaskForce\components\import;

use TaskForce\components\exception\ImportException;
use SplFileObject;

/**
 * Class Csv2SqlConverter
 * @package TaskForce\components\import
 */
class Csv2SqlConverter
{
	public static function parse(
		string $filePath,
		string $outPutDirectory
	): void
	{
		if (!file_exists($filePath)) {
			throw new ImportException('File does not exists');
		}

		$splFileObject = new SplFileObject($filePath);
		if ($splFileObject->getExtension() !== 'csv') {
			throw new ImportException('Invalid file extension');
		}

		if ($splFileObject->getSize() === 0) {
			throw new ImportException('File is empty');
		}

		/**/

		$columns = [];
		$values = [];

        /**
         * @note
         * get data from CSV into the array
         */
		while (!$splFileObject->eof()) {
			if ($splFileObject->key() === 0) {
				$columns = $splFileObject->fgetcsv();
			}

			$currentLineValues = $splFileObject->fgetcsv();
			if (count($columns) != count($currentLineValues)) {
				continue;
			}

			$valuesString = implode(', ', array_map(function($item) {
				return "'$item'";
			}, $currentLineValues));

			$valuesString = sprintf('(%s)', $valuesString);
			$values[] = $valuesString;
		}

        /**
         * @note
         * write data from array into the SQL file
         */
		$tableName = str_replace(
			'.csv',
			'',
			basename($splFileObject->getFileName())
		);

		$sqlQuery = sprintf(
			"INSERT INTO `%s` (%s) " . PHP_EOL . "VALUES " . PHP_EOL . "%s;",
			$tableName,
			implode(', ', array_map(function($item) {
				return "`$item`";
			}, $columns)),
			implode(', ' . PHP_EOL, $values)
		);

		$outputFileName = rtrim($outPutDirectory, DIRECTORY_SEPARATOR)
			. DIRECTORY_SEPARATOR . "$tableName.sql";

		if (!file_put_contents($outputFileName, $sqlQuery)) {
			throw new ImportException('Can not output SQL file');
		}
	}
}