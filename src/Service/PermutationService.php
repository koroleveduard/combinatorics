<?php

namespace App\Service;

use App\Iterator\CombinatoricsIteratorInterface;
use App\Iterator\PermutationCollection;

class PermutationService
{
    const MIN_COUNT_FOR_CALC = 10;

    private $iterator;

    private $fileDescriptor;

    private $logInFile = false;

    public function __construct($file = null)
    {
        if ($file && file_exists($file)) {
            $this->fileDescriptor = fopen($file, 'a');
            $this->logInFile = true;
        }
    }

    public function setIterator(CombinatoricsIteratorInterface $iterator): void
    {
        $this->iterator = $iterator;
    }

    public function getVariants(int $fieldsCount, int $chipCount): array
    {
        $result = [];
        $iterator = new PermutationCollection($fieldsCount, $chipCount);
        while ($iterator->hasNext()) {
            $result[] = $iterator->getNext();
        }

        return $result;
    }

    public function saveVariants(int $fieldsCount, int $chipCount): void
    {
        if (is_null($this->fileDescriptor)) {
            throw new \DomainException('Файловый дескриптор закрыт');
        }

        $mask = $this->getMask($fieldsCount);
        fwrite($this->fileDescriptor, $mask . PHP_EOL);

        $iterator = new PermutationCollection($fieldsCount, $chipCount);
        while ($iterator->hasNext()) {
            $value = $iterator->getNext();
            $value = $this->toString($fieldsCount, $value);
            fwrite($this->fileDescriptor, $value . PHP_EOL);
        }
    }

    public function getCount(int $fieldsCount, int $chipCount): int
    {
        $count = gmp_fact($fieldsCount) / (gmp_fact($fieldsCount-$chipCount) * gmp_fact($chipCount));

        return (int)$count;
    }

    public function saveCount(int $fieldsCount, int $chipCount): void
    {
        if (is_null($this->fileDescriptor)) {
            throw new \DomainException('Файловый дескриптор закрыт');
        }

        $count = $this->getCount($fieldsCount, $chipCount);

        if ($count < self::MIN_COUNT_FOR_CALC) {
            fwrite($this->fileDescriptor, 'Менее 10 вариантов!' . PHP_EOL);
        }

        fwrite($this->fileDescriptor, 'Найдено ' . $count . ' вариантов' . PHP_EOL);

        return ;
    }

    protected function getMask(int $fieldsCount): string
    {
        $line = [];

        for ($i=1; $i<=$fieldsCount; $i++) {
            $line[] = $i;
        }

        return implode(' ', $line);
    }

    protected function toString(int $fieldsCount, array $value): string
    {
        $line = [];

        for ($i=1; $i<=$fieldsCount; $i++) {
            if (in_array($i, $value)) {
                $line[] = '*';
            } else {
                $line[] = ' ';
            }
        }

        return implode(' ', $line);
    }

    public function __destruct()
    {
        if (!is_null($this->fileDescriptor)) {
            fclose($this->fileDescriptor);
        }
    }
}