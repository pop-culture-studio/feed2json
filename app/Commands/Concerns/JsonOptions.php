<?php

namespace App\Commands\Concerns;

trait JsonOptions
{
    protected int $json_options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
}
