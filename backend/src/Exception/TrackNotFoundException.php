<?php

namespace App\Exception;

class TrackNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct(sprintf('Track with ID %d not found.', $id));
    }
}