<?php declare(strict_types=1);
/** @var $this Phplrt\Compiler\Compiler */
echo '<?php' . "\n";
?>
/**
 * This file is part of Phplrt package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);
<?php
if ($this->namespace) {
    echo "\n" . \sprintf('namespace %s;', $this->namespace) . "\n";
}
?>

use Phplrt\Lexer\LexerInterface;
use Phplrt\Lexer\Driver\NativeRegex;
use Phplrt\Parser\Grammar;
use Phplrt\Parser\ParserInterface;
use Phplrt\Parser\Rule\Alternation;
use Phplrt\Parser\Rule\Concatenation;
use Phplrt\Parser\Rule\Repetition;
use Phplrt\Parser\Rule\Terminal;
use Phplrt\Parser\GrammarInterface;

/**
 * --- DO NOT EDIT THIS FILE ---
 *
 * Class <?=$this->class; ?> has been auto-generated.
 * Generated at: <?=\date('d-m-Y H:i:s') . "\n"; ?>
 *
 * --- DO NOT EDIT THIS FILE ---
 */
class <?=$this->class; ?> extends \Phplrt\Parser\Parser
{
<?php foreach ($this->getLexer()->getTokenDefinitions() as $token) : ?>
    public const <?=$token->getName(); ?> = <?=$this->render($token->getName()); ?>;
<?php endforeach; ?>

    /**
     * Lexical tokens list.
     *
     * @var string[]
     */
    protected const LEXER_TOKENS = [
<?php foreach ($this->getLexer()->getTokenDefinitions() as $token) : ?>
        self::<?=$token->getName(); ?> => <?=$this->render($token->getPcre()); ?>,
<?php endforeach; ?>
    ];

    /**
     * List of skipped tokens.
     *
     * @var string[]
     */
    protected const LEXER_SKIPPED_TOKENS = [
<?php foreach ($this->getLexer()->getTokenDefinitions() as $token) :
    if ($token->isKeep()) {
        continue;
    }
    ?>
        <?=$this->render($token->getName()); ?>,
<?php endforeach; ?>
    ];

    /**
     * List of rule delegates.
     *
     * @var string[]
     */
    protected const PARSER_DELEGATES = [
<?php foreach ($this->getGrammar()->getDelegates() as $rule => $delegate) : ?>
        <?=$this->render($rule); ?> => \<?=$delegate; ?>::class,
<?php endforeach; ?>
    ];

    /**
     * Parser root rule name.
     *
     * @var string
     */
    protected const PARSER_ROOT_RULE = <?=$this->render($this->getGrammar()->beginAt()); ?>;

    /**
     * <?=$this->class; ?> constructor.
     */
    public function __construct()
    {
        parent::__construct($this->createLexer(), $this->createGrammar());
    }

    /**
     * @return LexerInterface
     */
    protected function createLexer(): LexerInterface
    {
        return new NativeRegex(static::LEXER_TOKENS, static::LEXER_SKIPPED_TOKENS);
    }

    /**
     * @return GrammarInterface
     */
    protected function createGrammar(): GrammarInterface
    {
        return new Grammar($this->createGrammarRules(), static::PARSER_ROOT_RULE, static::PARSER_DELEGATES);
    }

    /**
     * @return array|\Phplrt\Parser\Rule\Rule[]
     */
    protected function createGrammarRules(): array
    {
        return [
            <?=\implode(', ' . "\n            ", require __DIR__ . '/rules.tpl.php'); ?>

        ];
    }
}