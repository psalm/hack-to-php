<?php
namespace Facebook\HHAST\__Private;

use HH\Lib\C as C;
use Facebook\HackCodegen\HackBuilderValues as HackBuilderValues;
final class CodegenEditableNodeFromJSON extends CodegenBase
{
    /**
     * @return void
     */
    public function generate()
    {
        $cg = $this->getCodegenFactory();
        $cg->codegenFile($this->getOutputDirectory() . '/editable_node_from_json.php')->setNamespace('Facebook\\HHAST\\__Private')->useNamespace('Facebook\\HHAST')->addFunction($cg->codegenFunction('editable_node_from_json')->setReturnType('HHAST\\EditableNode')->addParameter('dict<string, mixed> $json')->addParameter('string $file')->addParameter('int $offset')->addParameter('string $source')->setBody($cg->codegenHackBuilder()->startSwitch('(string) $json[\'kind\']')->addCase('token', HackBuilderValues::export())->add('return ')->addMultilineCall('HHAST\\EditableToken::fromJSON', array('/* HH_IGNORE_ERROR[4110] */ $json[\'token\']', '$file', '$offset', '$source'))->unindent()->addCase('list', HackBuilderValues::export())->returnCasef('HHAST\\EditableList::fromJSON($json, $file, $offset, $source)')->addCase('missing', HackBuilderValues::export())->addReturnf('HHAST\\Missing()')->unindent()->addCaseBlocks($this->getSchema()['trivia'], function ($trivia, $body) {
            return $body->addCase($trivia['trivia_type_name'], HackBuilderValues::export())->addReturnf('HHAST\\%s::fromJSON($json, $file, $offset, $source)', $trivia['trivia_kind_name'])->unindent();
        })->addCaseBlocks((new Vector($this->getSchema()['AST']))->filter(function ($ast) {
            return !C\contains_key(self::getHandWrittenSyntaxKinds(), $ast['kind_name']);
        }), function ($ast, $body) {
            return $body->addCase($ast['description'], HackBuilderValues::export())->addReturnf('HHAST\\%s::fromJSON($json, $file, $offset, $source)', $ast['kind_name'])->unindent();
        })->addDefault()->addMultilineCall('throw new HHAST\\UnsupportedASTNodeError', array('$file', '$offset', '(string) $json[\'kind\']'))->endDefault()->endSwitch()->getCode()))->save();
    }
}
