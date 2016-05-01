<?php

namespace Inkl\Csv\Writer;

class FileWriter
{

	private $fh;
	private $pos = 0;
	private $file;
	/**
	 * @var string
	 */
	private $delimiter;
	/**
	 * @var string
	 */
	private $enclosure;

	/**
	 * FileWriter constructor.
	 * @param $file
	 * @param string $delimiter
	 * @param string $enclosure
	 */
	public function __construct($file, $delimiter = ',', $enclosure = '"')
	{
		$this->file = $file;
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
	}


	public function open()
	{
		$this->fh = fopen($this->file, 'w');
	}


	public function write($data)
	{
		if ($this->pos == 0)
		{
			$this->writeLine(array_keys($data));
		}

		$this->writeLine($data);

		$this->pos++;
	}


	private function writeLine($data)
	{
		fwrite($this->fh, $this->enclosure . implode($this->enclosure . $this->delimiter . $this->enclosure, $data) . $this->enclosure . "\n");
	}


	public function close()
	{
		fclose($this->fh);
	}

}
