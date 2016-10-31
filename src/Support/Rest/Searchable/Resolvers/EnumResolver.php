<?php
namespace ImmediateSolutions\Support\Rest\Searchable\Resolvers;
use ImmediateSolutions\Support\Enum\Enum;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class EnumResolver
{
	/**
	 * @param string $value
	 * @param string $class
	 * @return bool
	 */
	public function isProcessable($value, $class)
	{
		return call_user_func([$class, 'has'], $value);
	}

	/**
	 * @param string $value
	 * @param string $class
	 * @return Enum
	 */
	public function resolve($value, $class)
	{
		return new $class($value);
	}
}