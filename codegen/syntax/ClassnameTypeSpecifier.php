<?php // strict
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<08bafd7156dbde9c1d1dba0412da4800>>
 */
namespace HackToPhp\HHAST;
use Facebook\TypeAssert;

final class ClassnameTypeSpecifier extends EditableNode {

  /**
   * @var EditableNode
   */
  private $_keyword;
  /**
   * @var EditableNode
   */
  private $_left_angle;
  /**
   * @var EditableNode
   */
  private $_type;
  /**
   * @var EditableNode
   */
  private $_trailing_comma;
  /**
   * @var EditableNode
   */
  private $_right_angle;

  public function __construct(
    EditableNode $keyword,
    EditableNode $left_angle,
    EditableNode $type,
    EditableNode $trailing_comma,
    EditableNode $right_angle
  ) {
    parent::__construct('classname_type_specifier');
    $this->_keyword = $keyword;
    $this->_left_angle = $left_angle;
    $this->_type = $type;
    $this->_trailing_comma = $trailing_comma;
    $this->_right_angle = $right_angle;
  }

  /**
   * @param array<string, mixed> $json
   * @return static
   */
  public static function fromJSON(
    array $json,
    string $file,
    int $offset,
    string $source
  ) {
    $keyword = EditableNode::fromJSON(
      /* UNSAFE_EXPR */ $json['classname_keyword'],
      $file,
      $offset,
      $source
    );
    $offset += $keyword->getWidth();
    $left_angle = EditableNode::fromJSON(
      /* UNSAFE_EXPR */ $json['classname_left_angle'],
      $file,
      $offset,
      $source
    );
    $offset += $left_angle->getWidth();
    $type = EditableNode::fromJSON(
      /* UNSAFE_EXPR */ $json['classname_type'],
      $file,
      $offset,
      $source
    );
    $offset += $type->getWidth();
    $trailing_comma = EditableNode::fromJSON(
      /* UNSAFE_EXPR */ $json['classname_trailing_comma'],
      $file,
      $offset,
      $source
    );
    $offset += $trailing_comma->getWidth();
    $right_angle = EditableNode::fromJSON(
      /* UNSAFE_EXPR */ $json['classname_right_angle'],
      $file,
      $offset,
      $source
    );
    $offset += $right_angle->getWidth();
    return
      new static($keyword, $left_angle, $type, $trailing_comma, $right_angle);
  }

  /**
   * @return array<string, EditableNode>
   */
  public function getChildren() : array {
    return [
      'keyword' => $this->_keyword,
      'left_angle' => $this->_left_angle,
      'type' => $this->_type,
      'trailing_comma' => $this->_trailing_comma,
      'right_angle' => $this->_right_angle,
    ];
  }

  /**
   * @psalm-param (\Closure(EditableNode, ?array<int, EditableNode>): EditableNode) $rewriter
   * @param ?array<int, EditableNode> $parents
   * @return static
   */
  public function rewriteDescendants(
    \Closure $rewriter,
    ?array $parents = null
  ) {
    $parents = $parents === null ? [] : vec($parents);
    $parents[] = $this;
    $keyword = $this->_keyword->rewrite($rewriter, $parents);
    $left_angle = $this->_left_angle->rewrite($rewriter, $parents);
    $type = $this->_type->rewrite($rewriter, $parents);
    $trailing_comma = $this->_trailing_comma->rewrite($rewriter, $parents);
    $right_angle = $this->_right_angle->rewrite($rewriter, $parents);
    if (
      $keyword === $this->_keyword &&
      $left_angle === $this->_left_angle &&
      $type === $this->_type &&
      $trailing_comma === $this->_trailing_comma &&
      $right_angle === $this->_right_angle
    ) {
      return $this;
    }
    return
      new static($keyword, $left_angle, $type, $trailing_comma, $right_angle);
  }

  public function getKeywordUNTYPED(): EditableNode {
    return $this->_keyword;
  }

  /**
   * @return static
   */
  public function withKeyword(EditableNode $value) {
    if ($value === $this->_keyword) {
      return $this;
    }
    return new static(
      $value,
      $this->_left_angle,
      $this->_type,
      $this->_trailing_comma,
      $this->_right_angle
    );
  }

  public function hasKeyword(): bool {
    return !$this->_keyword->isMissing();
  }

  /**
   * @return ClassnameToken
   */
  public function getKeyword(): ClassnameToken {
    \assert($this->_keyword instanceof ClassnameToken);
    return $this->_keyword;
  }

  /**
   * @return ClassnameToken
   */
  public function getKeywordx(): ClassnameToken {
    return $this->getKeyword();
  }

  public function getLeftAngleUNTYPED(): EditableNode {
    return $this->_left_angle;
  }

  /**
   * @return static
   */
  public function withLeftAngle(EditableNode $value) {
    if ($value === $this->_left_angle) {
      return $this;
    }
    return new static(
      $this->_keyword,
      $value,
      $this->_type,
      $this->_trailing_comma,
      $this->_right_angle
    );
  }

  public function hasLeftAngle(): bool {
    return !$this->_left_angle->isMissing();
  }

  /**
   * @return null | LessThanToken
   */
  public function getLeftAngle(): ?LessThanToken {
    if ($this->_left_angle->isMissing()) {
      return null;
    }
    \assert($this->_left_angle instanceof LessThanToken);
    return $this->_left_angle;
  }

  /**
   * @return LessThanToken
   */
  public function getLeftAnglex(): LessThanToken {
    \assert($this->_left_angle instanceof LessThanToken);
    return $this->_left_angle;
  }

  public function getTypeUNTYPED(): EditableNode {
    return $this->_type;
  }

  /**
   * @return static
   */
  public function withType(EditableNode $value) {
    if ($value === $this->_type) {
      return $this;
    }
    return new static(
      $this->_keyword,
      $this->_left_angle,
      $value,
      $this->_trailing_comma,
      $this->_right_angle
    );
  }

  public function hasType(): bool {
    return !$this->_type->isMissing();
  }

  /**
   * @return null | SimpleTypeSpecifier | TypeConstant
   */
  public function getType(): ?EditableNode {
    if ($this->_type->isMissing()) {
      return null;
    }
    \assert($this->_type instanceof EditableNode);
    return $this->_type;
  }

  /**
   * @return SimpleTypeSpecifier | TypeConstant
   */
  public function getTypex(): EditableNode {
    \assert($this->_type instanceof EditableNode);
    return $this->_type;
  }

  public function getTrailingCommaUNTYPED(): EditableNode {
    return $this->_trailing_comma;
  }

  /**
   * @return static
   */
  public function withTrailingComma(EditableNode $value) {
    if ($value === $this->_trailing_comma) {
      return $this;
    }
    return new static(
      $this->_keyword,
      $this->_left_angle,
      $this->_type,
      $value,
      $this->_right_angle
    );
  }

  public function hasTrailingComma(): bool {
    return !$this->_trailing_comma->isMissing();
  }

  /**
   * @return Missing
   */
  public function getTrailingComma(): ?EditableNode {
    if ($this->_trailing_comma->isMissing()) {
      return null;
    }
    \assert($this->_trailing_comma instanceof EditableNode);
    return $this->_trailing_comma;
  }

  /**
   * @return s
   */
  public function getTrailingCommax(): EditableNode {
    \assert($this->_trailing_comma instanceof EditableNode);
    return $this->_trailing_comma;
  }

  public function getRightAngleUNTYPED(): EditableNode {
    return $this->_right_angle;
  }

  /**
   * @return static
   */
  public function withRightAngle(EditableNode $value) {
    if ($value === $this->_right_angle) {
      return $this;
    }
    return new static(
      $this->_keyword,
      $this->_left_angle,
      $this->_type,
      $this->_trailing_comma,
      $value
    );
  }

  public function hasRightAngle(): bool {
    return !$this->_right_angle->isMissing();
  }

  /**
   * @return null | GreaterThanToken
   */
  public function getRightAngle(): ?GreaterThanToken {
    if ($this->_right_angle->isMissing()) {
      return null;
    }
    \assert($this->_right_angle instanceof GreaterThanToken);
    return $this->_right_angle;
  }

  /**
   * @return GreaterThanToken
   */
  public function getRightAnglex(): GreaterThanToken {
    \assert($this->_right_angle instanceof GreaterThanToken);
    return $this->_right_angle;
  }
}
