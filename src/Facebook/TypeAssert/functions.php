<?php

namespace Facebook\TypeAssert;

/**
 * @template T
 * @param T::class $class
 * @param mixed $oject
 * @return T
 */
function instance_of(string $class, $object)
{
	if (!$object instanceof $class) {
		throw new \UnexpectedValueException('Object should be a ' . $class);
	}

	return $object;
}

/**
 * @template T
 * @param ?T $object
 * @return T
 */
function not_null($object)
{
	if ($object === null) {
		throw new \UnexpectedValueException('Object should not be null ');
	}

	return $object;
}

/**
 * @param mixed $i
 * @return int
 */
function int($object) : int
{
	if (!\is_int($object)) {
		throw new \UnexpectedValueException('Object should be an int');
	}

	return $object;
}