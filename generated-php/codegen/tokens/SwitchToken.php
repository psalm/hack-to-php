<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<b784e52120b46d2474c2d37f5cc421c9>>
 */
namespace Facebook\HHAST;

final class SwitchToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'switch';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'switch', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

