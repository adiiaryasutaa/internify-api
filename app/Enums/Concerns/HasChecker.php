<?php

declare(strict_types=1);

namespace App\Enums\Concerns;

use Illuminate\Support\Arr;

trait HasChecker
{
    public function __call(string $name, array $arguments): mixed
    {
        switch (true) {
            case 'is' === $name:
                if (1 === count($arguments) && is_string($arguments[0])) {
                    $arguments[0] = Arr::wrap($arguments);
                }

                foreach ($arguments[0] as $role) {
                    if ($this->{'is' . ucfirst($role)}()) {
                        return true;
                    }
                }

                return false;

            case 'isNot' === $name:
                return ! $this->{str($name)->remove('Not')->toString()}($arguments);

            case str_starts_with($name, 'is'):
                $cases = Arr::mapWithKeys(
                    $this->cases(),
                    fn(self $role, int $key) => [str($role->name)->lower()->studly()->toString() => $role],
                );

                return $this === $cases[str($name)->substr(2)->toString()];

            case str_starts_with($name, 'isNot'):
                return ! $this->{str($name)->remove('Not')->toString()}();
        }

        return $this->{$name}(...$arguments);
    }
}
