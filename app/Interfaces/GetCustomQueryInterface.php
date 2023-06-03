<?php

namespace App\Interfaces;

interface GetCustomQueryInterface
{
    public function getCustomQueryColumn(string $column, $value);
}
