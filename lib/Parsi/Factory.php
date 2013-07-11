<?php

/**
 * Parsi\Factory
 * @package Parsi
 * @author  Ben Colegate
 */

namespace Parsi;

use \SplFileObject;
use \InvalidArgumentException;
use \Parsi\Writers\Csv as Writer;
use \Parsi\Readers\Csv as Reader;

class Factory
{

    /**
     * Factory create.
     * @param  string $class
     * @param  array  $args
     * @return stdClass
     */
    public static function create($class, array $args = array())
    {
        $self = new self();
        if (! method_exists($self, $class)) {
            throw new InvalidArgumentException;
        }

        return call_user_func_array(array($self, $class), $args);
    }

    /**
     * Return writer class.
     * @param  string $file
     * @return \Parsi\Writers\Csv
     */
    public function writer($file)
    {
        $file   = new SplFileObject($file, 'w+');
        $writer = new Writer($file);

        return $writer;
    }

    /**
     * Return reader class.
     * @param  string $file
     * @return \Parsi\Reader\Csv
     */
    public function reader($file)
    {
        $file   = new SplFileObject($file);
        $reader = new Reader($file);

        return $reader;
    }

}

/* End of File: ./lib/Parsi/Factory.php */
