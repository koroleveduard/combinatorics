<?php

namespace App\Iterator;

class PermutationCollection implements CombinatoricsIteratorInterface
{
    protected $n;

    protected $m;

    protected $currentCombination;

    public function __construct($n, $m)
    {
        $this->n = $n;
        $this->m = $m;
    }

    public function hasNext(): bool
    {
        if (is_null($this->currentCombination)) {
            $this->initionalCombination();
            return true;
        }

        $k = $this->m;
        for ($i = $k - 1; $i >= 0; --$i) {
            if ($this->currentCombination[$i] < $this->n - $k + $i + 1) {
                ++$this->currentCombination[$i];
                for ($j = $i + 1; $j < $k; ++$j) {
                    $this->currentCombination[$j] = $this->currentCombination[$j - 1] + 1;
                }

                return true;
            }
        }

        return false;
    }

    public function getNext(): array
    {
        $result = [];
        for ($i = 0; $i < $this->m; $i++) {
            $result[] =  $this->currentCombination[$i];
        }

        return $result;
    }

    protected function initionalCombination(): void
    {
        for ($i = 0; $i < $this->n; $i++) {
            $this->currentCombination[$i] = $i + 1;
        }
    }
}