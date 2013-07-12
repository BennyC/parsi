<?php

/**
 * Parsi\Readers\Csv
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi\Readers;

use \SplFileObject;

class CsvTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        // CSV can be found in adjacent folder
        $this->file = new SplFileObject(__DIR__."/../Fixtures/test.csv");
        $this->csv  = new Csv($this->file);
    }

    public function testExistence()
    {
        $this->assertTrue(class_exists('\Parsi\Readers\Csv'));
    }

    /**
     * @covers \Parsi\Readers\Csv::data
     */
    public function testDataReturnsAnArray()
    {
        $result = $this->csv->data();
        $this->assertInternalType('array', $result, 'Array is populated.');
    }

    /**
     * @covers \Parsi\Readers\Csv::load
     */
    public function testConstructionWithAFile()
    {
        $result = $this->csv->data();
        $this->assertContains(array(1, 2, 3, 4, 5), $result, 'Contains second row of CSV.');
    }

    /**
     * @covers \Parsi\Readers\Csv::load
     * @covers \Parsi\Readers\Csv::headers
     */
    public function testSettingOfHeadersRow()
    {
        $result = $this->csv->headers()->data();
        $this->assertArrayHasKey('one', $result[0], 'Assert associative keys have been made in comparison to the first row of the CSV.');
    }

    /**
     * @covers \Parsi\Readers\Csv::__construct
     */
    public function testHeadersWithConstruction()
    {
        $csv  = new Csv($this->file, true);
        $data = $csv->data();

        $this->assertArrayHasKey('one', $data[0]);
    }

    /**
     * @covers \Parsi\Readers\Csv::__construct
     */
    public function testThrowingExceptionWhenNoFileIsPassedIn()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $csv = new Csv();
    }

}

/* End of File: ./tests/Parsi/Readers/Csv.php */
