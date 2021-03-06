<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<e9279adee898a768a3daa6f31ca0b7c0>>
 */
namespace Facebook\HHAST;

final class MixedToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'mixed';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'mixed', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

