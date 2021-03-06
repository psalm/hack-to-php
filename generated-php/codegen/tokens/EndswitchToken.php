<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<188dbb98a6c56a101757fe160f5b3d4a>>
 */
namespace Facebook\HHAST;

final class EndswitchToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'endswitch';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'endswitch', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

