<?php

/**
 * Parsi\FactoryTest
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testExistence()
    {
        $this->assertTrue(class_exists('\Parsi\Factory'));
    }

    /**
     * @covers \Parsi\Factory::create
     * @covers \Parsi\Factory::writer
     */
    public function testWriterReturnsWriterAssociatedToFile()
    {
        $args = array(__DIR__.'/Fixtures/create-test.csv');
        $csv  = Factory::create('writer', $args);

        $this->assertInstanceOf('\Parsi\Writers\Csv', $csv);
        $this->assertEquals($csv->getFile()->getRealPath(), $args[0]);
    }

    /**
     * @covers \Parsi\Factory::create
     * @covers \Parsi\Factory::reader
     */
    public function testReaderReturnsReaderAssociatedToFile()
    {
        $args = array(__DIR__.'/Fixtures/test.csv');
        $csv  = Factory::create('reader', $args);

        $this->assertInstanceOf('\Parsi\Readers\Csv', $csv);
    }

    /**
     * @covers \Parsi\Factory::create
     */
    public function testExceptionThrownWhenInvalidClassIsAskedFor()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Factory::create('fake');
    }


}

/* End of File: ./tests/Parsi/Factory.php */
