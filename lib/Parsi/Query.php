<?php

/**
 * Parsi\Query
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi;

class Query
{

    /**
     * @var array $select
     */
    private $select = array();

    /**
     * @var \Parsi\Interfaces\Reader $data
     */
    private $data;

    /**
     * @var array $statements
     */
    private $statements = array();

    /**
     * Columns that you want to return.
     * @param  array|string $sel
     * @return self
     */
    public function select($sel = array())
    {
        // If string and not equal to *, convert to array.
        // If it is *, fake a select all with empty array.
        if (! is_array($sel) && $sel != '*') {
            $sel = array($sel);
        } else if ($sel == '*') {
            $sel = array();
        }

        $this->select = $sel;
        return $this;
    }

    /**
     * Return selected column names.
     * @return array
     */
    public function selected()
    {
        return $this->select;
    }

    /**
     * Store a where statement.
     * @param  string $col
     * @param  string $operator
     * @param  string $val
     * @return self
     */
    public function where($col, $operator, $val)
    {
        $fn = null;
        switch ($operator) {
            case '=':
                $fn = 'equals';
                break;
            case '<=':
                $fn = 'lessThanEquals';
                break;
            case '<':
                $fn = 'lessThan';
                break;
            case '>':
                $fn = 'greaterThan';
                break;
            case '>=':
                $fn = 'greaterThanEquals';
                break;
            case '!=':
                $fn = 'doesNotEqual';
                break;
        }

        $st = array(
            'col' => $col,
            'op'  => $fn,
            'val' => $val,
        );

        array_push($this->statements, $st);
        return $this;
    }

    /**
     * Return statements for the query.
     * @return array
     */
    public function statements()
    {
        return $this->statements;
    }

    /**
     * Data set to perform the query against.
     * @param  \Parsi\Interfaces\Reader $data
     * @return self
     */
    public function from($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Convenience function to make magic syntax!
     * @param  \Parsi\Interfaces\Reader $data
     * @return self
     */
    public static function query($data)
    {
        $self = new self();
        $self->from($data);

        return $self;
    }

    /**
     * Return the selected data set.
     * @return array
     */
    public function get()
    {
        $self = $this;
        $tmp = array_map(function ($row) use ($self) {
            // Default all cols
            $cols = $row;

            // Loop statements and check against!
            foreach ($self->statements() as $st) {
                if (! $self->$st['op']($row[$st['col']], $st['val'])) {
                    return false;
                }
            }

            // Reduce cols to cols selected
            if ($sel = $self->selected()) {
                $cols = array_intersect_key($cols, array_flip($sel));
            }

            return $cols;
        }, $this->data->data());

        return array_values(array_filter($tmp));
    }

    /**
     * Does not equal statement.
     * @return bool
     */
    public function doesNotEqual($col, $val)
    {
        return $col != $val;
    }

    /**
     * Equals statement.
     * @return bool
     */
    public function equals($col, $val)
    {
        return $col == $val;
    }

    /**
     * Less than statement.
     * @return bool
     */
    public function lessThan($col, $val)
    {
        return $col < $val;
    }

    /**
     * Less than equals statement.
     * @return bool
     */
    public function lessThanEquals($col, $val)
    {
        return $col <= $val;
    }

    /**
     * Greater than statement.
     * @return bool
     */
    public function greaterThan($col, $val)
    {
        return $col > $val;
    }

    /**
     * Greater than equals statement.
     * @return bool
     */
    public function greaterThanEquals($col, $val)
    {
        return $col >= $val;
    }

}

/* End of File: ./lib/Parsi/Query.php */
