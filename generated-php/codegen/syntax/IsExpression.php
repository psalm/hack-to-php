<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<ca21f6d340049b7ae5a328e941483487>>
 */
namespace Facebook\HHAST;

use Facebook\TypeAssert as TypeAssert;
final class IsExpression extends EditableNode
{
    /**
     * @var EditableNode
     */
    private $_left_operand;
    /**
     * @var EditableNode
     */
    private $_operator;
    /**
     * @var EditableNode
     */
    private $_right_operand;
    public function __construct(EditableNode $left_operand, EditableNode $operator, EditableNode $right_operand)
    {
        parent::__construct('is_expression');
        $this->_left_operand = $left_operand;
        $this->_operator = $operator;
        $this->_right_operand = $right_operand;
    }
    /**
     * @param array<string, mixed> $json
     *
     * @return static
     */
    public static function fromJSON(array $json, string $file, int $offset, string $source)
    {
        $left_operand = EditableNode::fromJSON($json['is_left_operand'], $file, $offset, $source);
        $offset += $left_operand->getWidth();
        $operator = EditableNode::fromJSON($json['is_operator'], $file, $offset, $source);
        $offset += $operator->getWidth();
        $right_operand = EditableNode::fromJSON($json['is_right_operand'], $file, $offset, $source);
        $offset += $right_operand->getWidth();
        return new static($left_operand, $operator, $right_operand);
    }
    /**
     * @return array<string, EditableNode>
     */
    public function getChildren()
    {
        return array('left_operand' => $this->_left_operand, 'operator' => $this->_operator, 'right_operand' => $this->_right_operand);
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
        $left_operand = $this->_left_operand->rewrite($rewriter, $parents);
        $operator = $this->_operator->rewrite($rewriter, $parents);
        $right_operand = $this->_right_operand->rewrite($rewriter, $parents);
        if ($left_operand === $this->_left_operand && $operator === $this->_operator && $right_operand === $this->_right_operand) {
            return $this;
        }
        return new static($left_operand, $operator, $right_operand);
    }
    /**
     * @return EditableNode
     */
    public function getLeftOperandUNTYPED()
    {
        return $this->_left_operand;
    }
    /**
     * @return static
     */
    public function withLeftOperand(EditableNode $value)
    {
        if ($value === $this->_left_operand) {
            return $this;
        }
        return new static($value, $this->_operator, $this->_right_operand);
    }
    /**
     * @return bool
     */
    public function hasLeftOperand()
    {
        return !$this->_left_operand->isMissing();
    }
    /**
     * @return FunctionCallExpression | LiteralExpression |
     * MemberSelectionExpression | ParenthesizedExpression |
     * PipeVariableExpression | PrefixUnaryExpression | RightParenToken |
     * VariableExpression
     */
    /**
     * @return EditableNode
     */
    public function getLeftOperand()
    {
        return TypeAssert\instance_of(EditableNode::class, $this->_left_operand);
    }
    /**
     * @return FunctionCallExpression | LiteralExpression |
     * MemberSelectionExpression | ParenthesizedExpression |
     * PipeVariableExpression | PrefixUnaryExpression | RightParenToken |
     * VariableExpression
     */
    /**
     * @return EditableNode
     */
    public function getLeftOperandx()
    {
        return $this->getLeftOperand();
    }
    /**
     * @return EditableNode
     */
    public function getOperatorUNTYPED()
    {
        return $this->_operator;
    }
    /**
     * @return static
     */
    public function withOperator(EditableNode $value)
    {
        if ($value === $this->_operator) {
            return $this;
        }
        return new static($this->_left_operand, $value, $this->_right_operand);
    }
    /**
     * @return bool
     */
    public function hasOperator()
    {
        return !$this->_operator->isMissing();
    }
    /**
     * @return IsToken
     */
    /**
     * @return IsToken
     */
    public function getOperator()
    {
        return TypeAssert\instance_of(IsToken::class, $this->_operator);
    }
    /**
     * @return IsToken
     */
    /**
     * @return IsToken
     */
    public function getOperatorx()
    {
        return $this->getOperator();
    }
    /**
     * @return EditableNode
     */
    public function getRightOperandUNTYPED()
    {
        return $this->_right_operand;
    }
    /**
     * @return static
     */
    public function withRightOperand(EditableNode $value)
    {
        if ($value === $this->_right_operand) {
            return $this;
        }
        return new static($this->_left_operand, $this->_operator, $value);
    }
    /**
     * @return bool
     */
    public function hasRightOperand()
    {
        return !$this->_right_operand->isMissing();
    }
    /**
     * @return ClosureTypeSpecifier | DictionaryTypeSpecifier |
     * GenericTypeSpecifier | KeysetTypeSpecifier | NullableTypeSpecifier |
     * ShapeTypeSpecifier | SimpleTypeSpecifier | SoftTypeSpecifier |
     * TupleTypeSpecifier | TypeConstant | VectorTypeSpecifier
     */
    /**
     * @return EditableNode
     */
    public function getRightOperand()
    {
        return TypeAssert\instance_of(EditableNode::class, $this->_right_operand);
    }
    /**
     * @return ClosureTypeSpecifier | DictionaryTypeSpecifier |
     * GenericTypeSpecifier | KeysetTypeSpecifier | NullableTypeSpecifier |
     * ShapeTypeSpecifier | SimpleTypeSpecifier | SoftTypeSpecifier |
     * TupleTypeSpecifier | TypeConstant | VectorTypeSpecifier
     */
    /**
     * @return EditableNode
     */
    public function getRightOperandx()
    {
        return $this->getRightOperand();
    }
}

