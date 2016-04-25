<?php

namespace Inkl\Csv\Service;

class StringService
{

	/**
	 * Convert csv content to array, first row is used for header
	 *
	 * @param string $content
	 * @param string $delimiter
	 * @return array
	 * @throws \Exception
	 */
	public function toArray($content, $delimiter = ',') {

		$csvStream = fopen('php://memory', 'w');
		fwrite($csvStream, $content);
		rewind($csvStream);

		$rows = [];

		$header = [];
		$i = 0;
		while (($data = fgetcsv($csvStream, 250000, $delimiter)) !== FALSE) {

			$i++;

			if ($i==1) {
				$header = $data;
				continue;
			}

			if (count($header) != count($data)) {

				file_put_contents('column_count.csv', $content);

				throw new \Exception(sprintf('column count not match in row %d', $i));

			}

			$rowData = [];
			foreach ($header as $key => $name) {
				$rowData[$name] = $data[$key];
			}

			$rows[] = $rowData;

		}
		fclose($csvStream);

		return $rows;
	}

}
