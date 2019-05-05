<?php
/**
 * This file is part of Phplrt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Phplrt\Exception\MutableException;

/**
 * Trait MutableFileTrait
 *
 * @mixin MutableFileInterface
 * @mixin \Exception
 */
trait MutableFileTrait
{
    /**
     * @param string $name
     * @return MutableFileInterface|$this
     */
    public function withFile(string $name): MutableFileInterface
    {
        $this->file = $name;

        return $this;
    }
}
