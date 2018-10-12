<?php

namespace App\Iterator;


interface CombinatoricsIteratorInterface
{
    public function hasNext(): bool;
    public function getNext(): array;
}