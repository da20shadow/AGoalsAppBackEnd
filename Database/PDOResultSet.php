<?php

namespace Database;

use Generator;
use PDOStatement;

class PDOResultSet
{
    private PDOStatement $pdoStatement;

    /**
     * @param PDOStatement $pdoStatement
     */
    public function __construct(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @param $className
     * @return Generator
     */
    public function fetch($className): Generator
    {
        while ($row = $this->pdoStatement->fetchObject($className)){

            yield $row;
        }
    }
}