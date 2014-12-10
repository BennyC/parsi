<?php

/**
 * Parsi\Writers\Csv
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi\Writers;

use \SplFileObject;
use \InvalidArgumentException;

class Csv
{

    /**
     * @var array $data
     */
    private $data;

    /**
     * __construct
     */
    public function __construct(SplFileObject $file, $data = array())
    {
        $this->file = $file;
        $this->setData($data);
    }

    /**
     * Populate file with CSV data.
     * @return self
     */
    public function create()
    {
        foreach ($this->getData() as $row) {
            $str = join(',', $row).PHP_EOL;
            $this->file->fwrite($str);
        }
    }

    /**
     * Getter for data.
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter for data.
     * @param  array $data
     * @return self
     */
    public function setData($data)
    {
        if (! is_array($data)) {
            throw new InvalidArgumentException();
        }

        $this->data = $data;
        return $this;
    }

    /**
     * Return file location for the new CSV.
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

}

/* End of File: ./lib/Parsi/Writers/Csv.php */
