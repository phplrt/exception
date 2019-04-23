<?php
/**
 * This file is part of phplrt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Phplrt\Exception\Trace;

/**
 * Interface Renderable
 */
interface Renderable
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function toString(): string;
}
