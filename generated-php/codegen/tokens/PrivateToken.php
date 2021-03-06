<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<7e31701a4e655d83836d868940d5b6cf>>
 */
namespace Facebook\HHAST;

final class PrivateToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'private';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'private', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

