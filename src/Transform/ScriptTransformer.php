<?php

namespace HackToPhp\Transform;

use HackToPhp\HHAST;
use PhpParser;

class ScriptTransformer
{
	public static function transform(HHAST\Script $node, HackFile $file, Scope $scope)
	{
		$declarations = array_values($node->getDeclarations()->getChildren());

		$stmts = [];

		foreach ($declarations as $i => $declaration) {
			if ($declaration instanceof HHAST\NamespaceDeclaration) {
				$file->namespace = $declaration->getQualifiedNameAsString();
				return [
					new PhpParser\Node\Stmt\Namespace_(
						new PhpParser\Node\Name($file->namespace),
						array_map(
							function(HHAST\EditableNode $node) use ($file, $scope) {
								return NodeTransformer::transform($node, $file, $scope);
							},
							array_slice($declarations, $i + 1)
						)
					)
				];
			}

			$stmts[] = NodeTransformer::transform($declaration, $file, $scope);
		}

		return $stmts;
	}
}