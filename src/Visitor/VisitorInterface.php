<?php
/**
 * This file is part of phplrt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Phplrt\Visitor;

use Phplrt\Contracts\Ast\NodeInterface;

/**
 * Interface VisitorInterface
 */
interface VisitorInterface
{
    /**
     * Called once before traversal.
     *
     * @param NodeInterface $node
     * @return NodeInterface|null
     */
    public function before(NodeInterface $node): ?NodeInterface;

    /**
     * Called when entering a node.
     *
     * @param NodeInterface $node
     * @return mixed
     */
    public function enter(NodeInterface $node);

    /**
     * Called when leaving a node.
     *
     * @param NodeInterface $node
     * @return mixed
     */
    public function leave(NodeInterface $node);

    /**
     * Called once after traversal.
     *
     * @param NodeInterface $node
     * @return NodeInterface|null
     */
    public function after(NodeInterface $node): ?NodeInterface;
}