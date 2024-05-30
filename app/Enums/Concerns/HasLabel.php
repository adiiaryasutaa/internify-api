<?php

declare(strict_types=1);

namespace App\Enums\Concerns;

trait HasLabel
{
    public static function columnComment(): string
    {
        return __('[:comment]', ['comment' => collect(self::labelsWithKeys())
            ->map(fn(string $label, $key) => "{$key}: {$label}")
            ->join(', ')]);
    }

    public static function labelForFilter(): array
    {
        return collect(self::labels())
            ->mapWithKeys(fn(string $label, int $i) => [++$i => $label])
            ->toArray();
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case, int $i) => [++$i => str($case->name)->lower()->headline()])
            ->toArray();
    }

    public static function labels(): array
    {
        return array_values(self::labelsWithKeys());
    }

    public static function labelsWithKeys(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => str($case->name)->lower()->headline()->toString()])
            ->toArray();
    }

    public function label(): string
    {
        return data_get(self::labelsWithKeys(), $this->value);
    }
}
