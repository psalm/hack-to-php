<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<9ca93eb5494795e19ee85a8317707f69>>
 */
namespace Facebook\HHAST;

final class ArrayToken extends EditableTokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'array';
    public function __construct(EditableNode $leading, EditableNode $trailing, string $token_text = 'array')
    {
        parent::__construct($leading, $trailing, $token_text);
    }
    /**
     * @return bool
     */
    public function hasLeading()
    {
        return !$this->getLeading()->isMissing();
    }
    /**
     * @return static
     */
    public function withLeading(EditableNode $value)
    {
        if ($value === $this->getLeading()) {
            return $this;
        }
        return new self($value, $this->getTrailing());
    }
    /**
     * @return bool
     */
    public function hasTrailing()
    {
        return !$this->getTrailing()->isMissing();
    }
    /**
     * @return static
     */
    public function withTrailing(EditableNode $value)
    {
        if ($value === $this->getTrailing()) {
            return $this;
        }
        return new self($this->getLeading(), $value);
    }
    /**
     * @param mixed $rewriter
     * @param array<int, EditableNode>|null $parents
     *
     * @return static
     */
    public function rewriteDescendants($rewriter, ?array $parents = null)
    {
        $parents = $parents === null ? array() : (array) $parents;
        $parents[] = $this;
        $leading = $this->getLeading()->rewrite($rewriter, $parents);
        $trailing = $this->getTrailing()->rewrite($rewriter, $parents);
        if ($leading === $this->getLeading() && $trailing === $this->getTrailing()) {
            return $this;
        }
        return new self($leading, $trailing);
    }
}

