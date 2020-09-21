<?php

namespace App\Parsing;

use Illuminate\Support\Collection;

class Parser extends \ParsedownExtra
{
    /** @var Collection */
    protected $transformations;

    public function __construct(Collection $transformations)
    {
        $this->transformations = $transformations;
    }

    public static function render($input)
    {
        return (new static)->text($input);
    }

    protected function lines($lines)
    {
        foreach ($lines as &$line) {
            $this->transformations->each(function ($transformation) use (&$line) {
                $line = $transformation->transform($line);
            });
        }

        return parent::lines($lines);
    }
}
