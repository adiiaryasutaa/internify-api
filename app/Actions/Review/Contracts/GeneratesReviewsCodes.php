<?php

declare(strict_types=1);

namespace App\Actions\Review\Contracts;

interface GeneratesReviewsCodes
{
    public function generate();
}
