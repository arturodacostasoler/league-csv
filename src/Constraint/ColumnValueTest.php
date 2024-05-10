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

namespace League\Csv\Constraint;

use League\Csv\StatementError;
use PHPUnit\Framework\Attributes\Test;

final class ColumnValueTest extends ContraintTestCase
{
    #[Test]
    public function it_can_filter_the_tabular_data_based_on_the_column_value(): void
    {
        $predicate = ColumnValue::filterOn('Country', '=', 'UK');
        $result = $this->stmt->where($predicate)->process($this->document);

        self::assertCount(1, $result);
    }

    #[Test]
    public function it_can_filter_the_tabular_data_based_on_the_column_value_and_the_column_offset(): void
    {
        $predicate = ColumnValue::filterOn(0, 'in', ['1', '2']);
        $result = $this->stmt->where($predicate)->process($this->document);

        self::assertCount(2, $result);
    }

    #[Test]
    public function it_can_not_filter_the_tabular_data_based_on_the_column_name(): void
    {
        $predicate = ColumnValue::filterOn('Country', '=', 'Country');
        $result = $this->stmt->where($predicate)->process($this->document);

        self::assertCount(0, $result);
    }

    public function it_will_throw_if_the_column_does_not_exist(): void
    {
        $predicate = ColumnValue::filterOn('City', '=', 'Dakar');
        //$this->expectExceptionObject(StatementError::dueToUnknownColumn('City'));

        $this->stmt->where($predicate)->process($this->document);

    }
}
