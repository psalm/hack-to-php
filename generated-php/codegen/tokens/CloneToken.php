<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<acdca449ea00281328a130d32ea8350b>>
 */
namespace Facebook\HHAST;

final class CloneToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'clone';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'clone', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

