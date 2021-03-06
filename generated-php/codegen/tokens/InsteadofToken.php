<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<c4b17ba925b306c66eaa33fd8bd4f5b5>>
 */
namespace Facebook\HHAST;

final class InsteadofToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'insteadof';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'insteadof', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

