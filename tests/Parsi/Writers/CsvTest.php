<?php

/**
 * Parsi\Writers\CsvTest
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi\Writers;

use \SplFileObject;

class CsvTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->location = __DIR__.'/../Fixtures/create-test.csv';
        $this->file = new SplFileObject($this->location, 'w+');
        $this->csv  = new Csv($this->file);
    }

    public function testExistence()
    {
        $this->assertTrue(class_exists('\Parsi\Writers\Csv'));
    }

    /**
     * @covers \Parsi\Writers\Csv::__construct
     * @covers \Parsi\Writers\Csv::getFile
     */
    public function testConstructionOfWriterObject()
    {
        $this->assertEquals($this->file, $this->csv->getFile());
    }

    /**
     * @covers \Parsi\Writers\Csv::__construct
     * @covers \Parsi\Writers\Csv::setData
     */
    public function testConstructionWithInvalidDataParameter()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $csv = new Csv($this->file, 'fake data');
    }

    /**
     * @covers \Parsi\Writers\Csv::setData
     * @covers \Parsi\Writers\Csv::getData
     */
    public function testAddingOfDataSetsData()
    {
        $data = array(1, 2, 3);
        $this->csv->setData($data);

        $this->assertEquals($this->csv->getData(), $data);
    }

    /**
     * @covers \Parsi\Writers\Csv::create
     */
    public function testCreationOfFile()
    {
        $data = array(
            array(1, 2, 3),
            array(4, 5, 6),
        );
        $this->csv->setData($data)->create();

        $this->assertFileExists($this->location);
        $this->assertStringEqualsFile($this->location, "1,2,3\n4,5,6\n");
    }

}

/* End of File: ./tests/Parsi/Writers/Csv.php */
