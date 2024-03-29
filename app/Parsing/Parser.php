<?php

namespace App\Parsing;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Parser extends \ParsedownExtra
{
    /** @var Collection */
    protected $transformations;

    public function __construct(Collection $transformations)
    {
        $this->transformations = $transformations;

        $this->InlineTypes['^'] = ['Superscript'];
        $this->inlineMarkerList .= "^";

        parent::__construct();
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

            if(preg_match("/^:::\s(.+)/", $line, $matches)) {
                $line = "<div class='custom-block {$matches[1]}'>";
            }

            if(preg_match("/^:::$/", $line, $matches)) {
                $line = "</div>";
            }
        }

        return parent::lines($lines);
    }

    protected function inlineSuperscript($Excerpt)
    {
        if (preg_match('/^\^(.+?)\^/', $Excerpt['text'], $matches))
        {
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'sup',
                    'text' => $matches[1],
                    'handler' => 'line',
                ),
            );
        }
    }
}
