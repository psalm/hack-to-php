<?php

namespace HackToPhp\Transform;

use HackToPhp\HHAST;
use PhpParser;

class FunctionCallExpressionTransformer
{
	public static function transform(HHAST\FunctionCallExpression $node, HackFile $file) : PhpParser\Node
	{
		$receiver = $node->getReceiver();

		$args = self::transformArguments($node->getArgumentList(), $file);

		if ($receiver instanceof HHAST\ScopeResolutionExpression) {
			$qualifier = $receiver->getQualifier();

			if ($qualifier instanceof HHAST\NameToken) {
				$class = new PhpParser\Node\Name($qualifier->getText());
			} elseif ($qualifier instanceof HHAST\QualifiedName) {
				$class = QualifiedNameTransformer::transform($qualifier);
			} else {
				$class = ExpressionTransformer::transformVariableName($qualifier, $file);
			}
			
			$name = ExpressionTransformer::transformVariableName($receiver->getName(), $file);

			return new PhpParser\Node\Expr\StaticCall(
				$class,
				$name,
				$args
			);
		}

		if ($receiver instanceof HHAST\QualifiedName) {
			$name = QualifiedNameTransformer::transform($receiver);

			$name_string = QualifiedNameTransformer::getText($receiver, $file);

			if ($name_string === '\HH\Asio\join') {
				return new PhpParser\Node\Expr\MethodCall($args[0]->value, 'wait');
			}

			if ($name_string === '\HH\Lib\Str\length') {
				return new PhpParser\Node\Expr\FuncCall(
			    	new PhpParser\Node\Name\FullyQualified('strlen'),
			    	$args
				);
			}

			if ($name_string === '\is_dict') {
				return new PhpParser\Node\Expr\FuncCall(
			    	new PhpParser\Node\Name\FullyQualified('is_array'),
			    	$args
				);
			}

			if ($name_string === '\json_decode'
				&& isset($args[3])
				&& $args[3]->value instanceof PhpParser\Node\Expr\ConstFetch
				&& (string) $args[3]->value->name === 'JSON_FB_HACK_ARRAYS'
			) {
				return new PhpParser\Node\Expr\FuncCall(
			    	new PhpParser\Node\Name\FullyQualified('json_decode'),
			    	array_slice($args, 0, 3)
				);
			}

			return new PhpParser\Node\Expr\FuncCall(
		    	$name,
		    	$args
			);
		}

		if ($receiver instanceof HHAST\NameToken) {
			$name_string = $receiver->getText();

			if ($name_string === 'is_dict') {
				return new PhpParser\Node\Expr\FuncCall(
			    	new PhpParser\Node\Name\FullyQualified('is_array'),
			    	$args
				);
			}

			return new PhpParser\Node\Expr\FuncCall(
		    	new PhpParser\Node\Name($name_string),
		    	$args
			);
		}

		if ($receiver instanceof HHAST\MemberSelectionExpression) {
			$object = ExpressionTransformer::transform($receiver->getObject(), $file);
			$name = ExpressionTransformer::transformVariableName($receiver->getName(), $file);

			return new PhpParser\Node\Expr\MethodCall(
				$object,
				$name,
				$args
			);
		}

		var_dump($receiver);
	}

	public static function transformArguments(?HHAST\EditableList $node, HackFile $file) : array
	{
		if (!$node) {
			return [];
		}

		return array_map(
			function (HHAST\EditableNode $node) use ($file) {
				return new PhpParser\Node\Arg(
					ExpressionTransformer::transform($node->getItem(), $file)
				);
			},
			$node->getChildren()
		);
	}
}