<?php
/**
 * This file is generated. Do not modify it manually!
 *
 * @generated SignedSource<<0e3438da122e84e68490e2a995a51346>>
 */
namespace Facebook\HHAST;

final class FromToken extends TokenWithVariableText
{
    /**
     * @var string
     */
    const KIND = 'from';
    /**
     * @param NodeList<Trivia>|null $leading
     * @param NodeList<Trivia>|null $trailing
     */
    public function __construct(?NodeList $leading, ?NodeList $trailing, string $token_text = 'from', ?array $source_ref = null)
    {
        parent::__construct($leading, $trailing, $token_text, $source_ref);
    }
}

