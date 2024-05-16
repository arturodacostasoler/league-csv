<?php

/**
 * League.Csv (https://csv.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace League\Csv\Ordering;

use Closure;

use function array_map;

/**
 * Enable sorting a record based on multiple column.
 *
 * The class can be used with PHP's usort and uasort functions.
 *
 * @phpstan-import-type Ordering from SortCombinator
 * @phpstan-import-type OrderingExtended from SortCombinator
 */
final class MultiSort implements SortCombinator
{
    /** @var array<Ordering> */
    private readonly array $sorts;

    /**
     * @param OrderingExtended ...$sorts
     */
    private function __construct(Sort|Closure|callable ...$sorts)
    {
        $this->sorts = array_map(
            static fn (Sort|Closure|callable $sort): Sort|Closure => $sort instanceof Closure || $sort instanceof Sort ? $sort : $sort(...),
            $sorts
        );
    }

    /**
     * @param OrderingExtended ...$sorts
     */
    public static function all(Sort|Closure|callable ...$sorts): self
    {
        return new self(...$sorts);
    }

    /**
     * @param OrderingExtended ...$sorts
     */
    public function append(Sort|Closure|callable ...$sorts): self
    {
        if ([] === $sorts) {
            return $this;
        }

        return new self(...$this->sorts, ...$sorts);
    }

    /**
     * @param OrderingExtended ...$sorts
     */
    public function prepend(Sort|Closure|callable ...$sorts): self
    {
        if ([] === $sorts) {
            return $this;
        }

        return (new self(...$sorts))->append(...$this->sorts);
    }

    public function __invoke(mixed $valueA, mixed $valueB): int
    {
        foreach ($this->sorts as $sort) {
            if (0 !== ($result = $sort($valueA, $valueB))) {
                return $result;
            }
        }

        return $result ?? 0;
    }
}