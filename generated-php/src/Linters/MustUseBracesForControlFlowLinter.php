<?php
namespace Facebook\HHAST\Linters;

use Facebook\HHAST\{CompoundStatement as CompoundStatement, EditableList as EditableList, EditableNode as EditableNode, EditableToken as EditableToken, ElseClause as ElseClause, ElseifClause as ElseifClause, EndOfLine as EndOfLine, ForeachStatement as ForeachStatement, IfStatement as IfStatement, LeftBraceToken as LeftBraceToken, IControlFlowStatement as IControlFlowStatement, RightBraceToken as RightBraceToken, WhileStatement as WhileStatement, WhiteSpace as WhiteSpace};
use Facebook\HHAST as HHAST;
use HH\Lib\{C as C, Str as Str, Vec as Vec};
class MustUseBracesForControlFlowLinter extends AutoFixingASTLinter
{
    /**
     * @return IControlFlowStatement::class
     */
    protected static function getTargetType()
    {
        return IControlFlowStatement::class;
    }
    /**
     * @param array<int, EditableNode> $_parents
     *
     * @return ASTLintError<IControlFlowStatement>|null
     */
    public function getLintErrorForNode(IControlFlowStatement $node, array $_parents)
    {
        $body = $this->getBody($node);
        if ($body === null) {
            return null;
        }
        if ($body instanceof CompoundStatement) {
            return null;
        }
        if ($node instanceof ElseClause && $body instanceof IfStatement) {
            return null;
        }
        return new ASTLintError($this, Str\format('%s without braces', Str\replace($node->getSyntaxKind(), '_', ' ')), $node);
    }
    /**
     * @return null|EditableNode
     */
    private function getBody(EditableNode $node)
    {
        if ($node instanceof IfStatement) {
            return $node->getStatement();
        }
        if ($node instanceof ElseClause) {
            return $node->getStatement();
        }
        if ($node instanceof ElseifClause) {
            return $node->getStatement();
        }
        if ($node instanceof ForeachStatement) {
            return $node->getBody();
        }
        if ($node instanceof WhileStatement) {
            return $node->getBody();
        }
        return null;
    }
    /**
     * @return EditableToken
     */
    private function getLastHeadToken(EditableNode $node)
    {
        if ($node instanceof IfStatement) {
            $paren = $node->getRightParen();
            if ($paren !== null) {
                return $paren->getLastTokenx();
            }
            return $node->getCondition()->getLastTokenx();
        }
        if ($node instanceof ElseClause) {
            return $node->getKeyword();
        }
        if ($node instanceof ElseifClause) {
            return $node->getRightParen()->getLastTokenx();
        }
        if ($node instanceof ForeachStatement) {
            return $node->getRightParen()->getLastTokenx();
        }
        if ($node instanceof WhileStatement) {
            return $node->getRightParen()->getLastTokenx();
        }
        invariant_violation('unhandled type: %s', \get_class($node));
    }
    /**
     * @return IControlFlowStatement
     */
    public function getFixedNode(IControlFlowStatement $node)
    {
        $body = $this->getBody($node);
        invariant($body !== null, 'Can\'t fix a node with no body');
        $last_token = $this->getLastHeadToken($node);
        if (C\is_empty((array) $last_token->getTrailingWhitespace()->getDescendantsOfType(EndOfLine::class))) {
            $right_brace_leading = new WhiteSpace(' ');
            $body_trailing = HHAST\Missing();
        } else {
            $whitespace_nodes = $node->getFirstTokenx()->getLeadingWhitespace()->toVec();
            $no_newlines = array();
            foreach (Vec\reverse($whitespace_nodes) as $whitespace) {
                if ($whitespace instanceof EndOfLine) {
                    break;
                }
                $no_newlines[] = $whitespace;
            }
            $right_brace_leading = EditableList::createNonEmptyListOrMissing(Vec\reverse($no_newlines));
            $body_trailing = $body->getLastTokenx()->getTrailing();
        }
        return $node->replace($body, new CompoundStatement(new LeftBraceToken(new WhiteSpace(' '), $last_token->getTrailingWhitespace()), $body->replace($body->getLastTokenx(), $body->getLastTokenx()->withTrailing($body_trailing)), new RightBraceToken($right_brace_leading, $body->getLastTokenx()->getTrailingWhitespace())))->replace($last_token, $last_token->withTrailing(HHAST\Missing()));
    }
    /**
     * @return string
     */
    protected function getTitleForFix(LintError $_)
    {
        return 'Add braces';
    }
    /**
     * @return string
     */
    public function getPrettyTextForNode(IControlFlowStatement $node)
    {
        $token = $node->getFirstTokenx();
        return $node->replace($token, $token->withLeading($token->getLeadingWhitespace()))->getCode();
    }
}
