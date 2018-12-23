<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<bfce08f37ce67eefbc18dc87b0a8c848>>
 */
namespace Facebook\HHAST;

use Facebook\TypeAssert as TypeAssert;
final class PropertyDeclarator extends EditableNode
{
    /**
     * @var EditableNode
     */
    private $_name;
    /**
     * @var EditableNode
     */
    private $_initializer;
    public function __construct(EditableNode $name, EditableNode $initializer)
    {
        parent::__construct('property_declarator');
        $this->_name = $name;
        $this->_initializer = $initializer;
    }
    /**
     * @param array<string, mixed> $json
     *
     * @return static
     */
    public static function fromJSON(array $json, string $file, int $offset, string $source)
    {
        $name = EditableNode::fromJSON($json['property_name'], $file, $offset, $source);
        $offset += $name->getWidth();
        $initializer = EditableNode::fromJSON($json['property_initializer'], $file, $offset, $source);
        $offset += $initializer->getWidth();
        return new static($name, $initializer);
    }
    /**
     * @return array<string, EditableNode>
     */
    public function getChildren()
    {
        return array('name' => $this->_name, 'initializer' => $this->_initializer);
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
        $name = $this->_name->rewrite($rewriter, $parents);
        $initializer = $this->_initializer->rewrite($rewriter, $parents);
        if ($name === $this->_name && $initializer === $this->_initializer) {
            return $this;
        }
        return new static($name, $initializer);
    }
    /**
     * @return EditableNode
     */
    public function getNameUNTYPED()
    {
        return $this->_name;
    }
    /**
     * @return static
     */
    public function withName(EditableNode $value)
    {
        if ($value === $this->_name) {
            return $this;
        }
        return new static($value, $this->_initializer);
    }
    /**
     * @return bool
     */
    public function hasName()
    {
        return !$this->_name->isMissing();
    }
    /**
     * @return VariableToken
     */
    /**
     * @return VariableToken
     */
    public function getName()
    {
        return TypeAssert\instance_of(VariableToken::class, $this->_name);
    }
    /**
     * @return VariableToken
     */
    /**
     * @return VariableToken
     */
    public function getNamex()
    {
        return $this->getName();
    }
    /**
     * @return EditableNode
     */
    public function getInitializerUNTYPED()
    {
        return $this->_initializer;
    }
    /**
     * @return static
     */
    public function withInitializer(EditableNode $value)
    {
        if ($value === $this->_initializer) {
            return $this;
        }
        return new static($this->_name, $value);
    }
    /**
     * @return bool
     */
    public function hasInitializer()
    {
        return !$this->_initializer->isMissing();
    }
    /**
     * @return null | SimpleInitializer
     */
    /**
     * @return null|SimpleInitializer
     */
    public function getInitializer()
    {
        if ($this->_initializer->isMissing()) {
            return null;
        }
        return TypeAssert\instance_of(SimpleInitializer::class, $this->_initializer);
    }
    /**
     * @return SimpleInitializer
     */
    /**
     * @return SimpleInitializer
     */
    public function getInitializerx()
    {
        return TypeAssert\instance_of(SimpleInitializer::class, $this->_initializer);
    }
}

