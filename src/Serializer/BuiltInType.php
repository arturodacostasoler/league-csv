<?php

/**
 * League.Csv (https://csv.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Csv\Serializer;

enum BuiltInType: string
{
    case Bool = 'bool';
    case Int =  'int';
    case Float = 'float';
    case String = 'string';
    case Mixed = 'mixed';
}