<?php
namespace ImmediateSolutions\Core\Document\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DocumentPreferenceInterface
{
    /**
     * @return int
     */
    public function getLifeTime();

	/**
	 * @return string
	 */
	public function getBaseUrl();
}