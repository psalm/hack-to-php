<?php
namespace Facebook\HHAST\Linters;

use HH\Lib\Str as Str;
final class LinterException extends \Exception
{
    /**
     * @var BaseLinter::class
     */
    private $linter;
    /**
     * @var string
     */
    private $fileBeingLinted;
    /**
     * @var string
     */
    private $rawMessage;
    /**
     * @var array{0:int, 1:int}|null
     */
    private $position = null;
    /**
     * @var array{0:int, 1:int}|null
     */
    public function __construct(string $linter, string $fileBeingLinted, string $rawMessage, $position = null, ?\Throwable $previous = null)
    {
        $this->linter = $linter;
        $this->fileBeingLinted = $fileBeingLinted;
        $this->rawMessage = $rawMessage;
        $this->position = $position;
        parent::__construct(Str\format('While running \'%s\' on \'%s\': %s', $linter, $fileBeingLinted, $rawMessage), 0, $previous);
    }
    /**
     * @return BaseLinter::class
     */
    public function getLinterClass()
    {
        return $this->linter;
    }
    /**
     * @return string
     */
    public function getFileBeingLinted()
    {
        return $this->fileBeingLinted;
    }
    /**
     * @return string
     */
    public function getRawMessage()
    {
        return $this->rawMessage;
    }
    /**
     * @return array{0:int, 1:int}|null
     */
    public function getPosition()
    {
        return $this->position;
    }
}
