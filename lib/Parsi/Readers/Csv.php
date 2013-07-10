<?php

/**
 * Parsi\Readers\Csv
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi\Readers;

use \SplFileObject;
use \InvalidArgumentException;

class Csv implements \Parsi\Interfaces\Reader
{
    /**
     * @var array $data
     */
    private $data = array();

    /**
     * @var \SplFileObject $handler
     */
    private $handler = null;

    /**
     * @var boolean $headers
     */
    private $headers = false;

    /**
     * __construct
     */
    public function __construct(SplFileObject $handler = null, $headers = false)
    {
        if (empty($handler)) {
            throw new InvalidArgumentException();
        }

        $this->handler = $handler;
        $this->headers = $headers;
        $this->handler->setFlags(SplFileObject::DROP_NEW_LINE);
        $this->load();
    }

    /**
     * Return the data for the format.
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Load data and populate data array from File Handler.
     * @return self
     */
    public function load()
    {
        $this->data = array();
        $this->handler->rewind();

        if ($this->headers) {
            $headers = $this->handler->fgetcsv();
        }

        while (! $this->handler->eof()) {
            $row = $this->handler->fgetcsv();

            // @NOTE: PHP Bug: 55807 and 61032, returns new line char as null.
            if (is_null($row[0])) continue;

            $row = ($this->headers ? array_combine($headers, $row) : $row);
            array_push($this->data, $row);
        }

        return $this;
    }

    /**
     * Toggle whether the file contains headers.
     * @return self
     */
    public function headers($headers = true)
    {
        $this->headers = $headers;
        return $this;
    }

}

/* End of File: ./lib/Parsi/Formats/Csv.php */
