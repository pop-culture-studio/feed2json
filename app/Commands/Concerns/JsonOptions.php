<?php

namespace App\Commands\Concerns;

trait JsonOptions
{
    protected int $json_options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
}
