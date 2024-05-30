<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @mixin Company */
final class CompanyCollection extends ResourceCollection {}
