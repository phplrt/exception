<?php
/**
 * This file is part of phplrt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Phplrt\Exception;

use Phplrt\Source\File;
use Phplrt\Position\Position;
use Phplrt\Contracts\Source\FileInterface;
use Phplrt\Contracts\Source\ReadableInterface;
use Phplrt\Contracts\Exception\MutableSourceExceptionInterface;
use Phplrt\Contracts\Source\Exception\NotReadableExceptionInterface;

/**
 * Class SourceException
 */
class SourceException extends \RuntimeException implements MutableSourceExceptionInterface
{
    /**
     * @var int|null
     */
    private $column;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var string|ReadableInterface
     */
    private $readable;

    /**
     * @param ReadableInterface $readable
     * @param int $offset
     * @return MutableSourceExceptionInterface|$this
     * @throws NotReadableExceptionInterface
     */
    public function throwsIn(ReadableInterface $readable, int $offset): MutableSourceExceptionInterface
    {
        return $this->update($readable, Position::fromOffset($readable, $offset));
    }

    /**
     * @param ReadableInterface $readable
     * @param int $line
     * @param int $column
     * @return MutableSourceExceptionInterface|$this
     * @throws NotReadableExceptionInterface
     */
    public function throwsAt(ReadableInterface $readable, int $line, int $column): MutableSourceExceptionInterface
    {
        return $this->update($readable, Position::fromPosition($readable, $line, $column));
    }

    /**
     * @param ReadableInterface $src
     * @param Position $position
     * @return SourceException|$this
     */
    private function update(ReadableInterface $src, Position $position): self
    {
        $this->readable = $src;

        if ($src instanceof FileInterface) {
            $this->file = $src->getPathName();

            $this->offset = $position->getOffset();
            $this->line = $position->getLine();
            $this->column = $position->getColumn();
        }

        return $this;
    }

    /**
     * @return int
     * @throws NotReadableExceptionInterface
     */
    public function getColumn(): int
    {
        if ($this->column === null) {
            $column = $this->column ?? Position::MIN_COLUMN;

            $this->column = $this->offset === null
                ? Position::fromPosition($this->getSource(), $this->getLine(), $column)->getColumn()
                : Position::fromOffset($this->getSource(), $this->getOffset());
        }

        return $this->column;
    }

    /**
     * @return ReadableInterface
     */
    public function getSource(): ReadableInterface
    {
        if (! $this->readable) {
            $this->readable = File::fromPathName($this->getFile());
        }

        return $this->readable;
    }

    /**
     * @return int
     * @throws NotReadableExceptionInterface
     */
    public function getOffset(): int
    {
        if ($this->offset === null) {
            $column = $this->column ?? Position::MIN_COLUMN;

            $this->offset = Position::fromPosition($this->getSource(), $this->getLine(), $column)->getOffset();
        }

        return $this->offset;
    }
}
