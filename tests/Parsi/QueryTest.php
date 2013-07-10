<?php

/**
 * Parsi\Query
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi;

use \Parsi\Readers\Csv;
use \SplFileObject;

class QueryTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->csv   = new Csv(new SplFileObject(__DIR__.'/Fixtures/test.csv'));
        $this->query = new Query();
    }

    public function testExistence()
    {
        $this->assertTrue(class_exists('\Parsi\Query'));
    }

    /**
     * @covers \Parsi\Query::select
     * @covers \Parsi\Query::from
     * @covers \Parsi\Query::get
     */
    public function testSimpleSelectQuery()
    {
        $data = new Csv(new SplFileObject(__DIR__.'/Fixtures/test.csv'));
        $this->query->from($data);

        $result = $this->query->select('*')->get();
        $this->assertEquals($data->data(), $result);
    }

    /**
     * @covers \Parsi\Query::select
     * @covers \Parsi\Query::selected
     */
    public function testSelectOneColumns()
    {
        $this->query->from($this->csv)->select('0');
        $result = $this->query->get();
        $this->assertCount(1, $result[0]);
    }

    /**
     * @covers \Parsi\Query::select
     * @covers \Parsi\Query::from
     * @covers \Parsi\Query::get
     */
    public function testSimpleDifferentColumnsSelect()
    {
        $data = new Csv(new SplFileObject(__DIR__.'/Fixtures/test.csv'));
        $data = $data->headers()->load();

        $this->query->select(array('one', 'two'));
        $this->query->from($data);
        $result = $this->query->get();

        $this->assertEquals(array(
          array('one' => 1, 'two' => 2),
        ), $result);
    }

    /**
     * @covers \Parsi\Query::equals
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testSimpleWhereStatementAndSelectedColumns()
    {
        $data = new Csv(new SplFileObject(__DIR__.'/Fixtures/test.csv'));

        $this->query->select(1)->from($data);
        $this->query->where(0, '=', 1);
        $result = $this->query->get();

        $this->assertEquals(array(
          array(1 => 2),
        ), $result);
    }

    /**
     * @covers \Parsi\Query::doesNotEqual
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testDoesNotEqual()
    {
        $this->query->from($this->csv)
                    ->where(0, '!=', 1);

        $result = $this->query->get();
        $this->assertContains('one', $result[0]);
    }

    /**
     * @covers \Parsi\Query::lessThan
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testLessThan()
    {
        $this->query->from($this->csv)
                    ->where(0, '<', 0);
        $this->assertEmpty($this->query->get());
    }

    /**
     * @covers \Parsi\Query::lessThanEquals
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testLessThanEquals()
    {
        $this->query->from($this->csv)
                    ->where(0, '<=', 0);
        $this->assertNotEmpty($this->query->get());
    }

    /**
     * @covers \Parsi\Query::greaterThan
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testGreaterThan()
    {
        $this->query->from($this->csv)
                    ->where(0, '>', 100);

        $this->assertEmpty($this->query->get());
    }

    /**
     * @covers \Parsi\Query::greaterThanEquals
     * @covers \Parsi\Query::where
     * @covers \Parsi\Query::statements
     * @covers \Parsi\Query::get
     */
    public function testGreaterThanEquals()
    {
        $this->query->from($this->csv)
                    ->where(0, '>=', 1);

        $this->assertNotEmpty($this->query->get());
    }

    /**
     * @covers \Parsi\Query::query
     */
    public function testStaticQuery()
    {
        $result = Query::query($this->csv)->get();
        $this->assertInternalType('array', $result);
    }

}

/* End of File: ./tests/Parsi/Query.php */
