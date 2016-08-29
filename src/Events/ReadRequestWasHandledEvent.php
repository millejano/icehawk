<?php
/**
 * @author hollodotme
 */

namespace IceHawk\IceHawk\Events;

use IceHawk\IceHawk\Interfaces\ProvidesReadRequestData;
use IceHawk\IceHawk\Interfaces\ProvidesRequestInfo;
use IceHawk\IceHawk\PubSub\Interfaces\CarriesEventData;

/**
 * Class RequestWasHandledEvent
 * @package IceHawk\IceHawk\Events
 */
final class ReadRequestWasHandledEvent implements CarriesEventData
{
	/** @var ProvidesReadRequestData */
	private $request;

	public function __construct( ProvidesReadRequestData $request )
	{
		$this->request = $request;
	}

	public function getRequestInfo() : ProvidesRequestInfo
	{
		return $this->request->getRequestInfo();
	}

	public function getInputData() : array
	{
		return $this->request->getInputData();
	}
}