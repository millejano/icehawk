<?php declare(strict_types = 1);
/**
 * Copyright (c) 2016 Holger Woltersdorf & Contributors
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */

namespace IceHawk\IceHawk\Tests\Unit\Defaults;

use IceHawk\IceHawk\Defaults\FinalWriteResponder;
use IceHawk\IceHawk\Defaults\RequestInfo;
use IceHawk\IceHawk\Exceptions\UnresolvedRequest;
use IceHawk\IceHawk\Requests\WriteRequest;
use IceHawk\IceHawk\Requests\WriteRequestInput;
use IceHawk\IceHawk\Routing\RouteRequest;

/**
 * Class FinalWriteRequestResponderTest
 * @package IceHawk\IceHawk\Tests\Unit\Defaults
 */
class FinalWriteRequestResponderTest extends \PHPUnit_Framework_TestCase
{
	public function testHandleUncaughtException()
	{
		$requestInfo = new RequestInfo(
			[
				'REQUEST_METHOD' => 'GET',
				'REQUEST_URI'    => '/domain/ice_hawk_read',
			]
		);

		$routeRequest = new RouteRequest( $requestInfo->getUri(), $requestInfo->getMethod() );
		$requestData  = new WriteRequest( $requestInfo, new WriteRequestInput( '', [] ) );

		try
		{
			$unresolvedRequest = (new UnresolvedRequest())->withDestinationInfo( $routeRequest );

			$responder = new FinalWriteResponder();
			$responder->handleUncaughtException( $unresolvedRequest, $requestData );

			$this->fail( 'No Exception thrown' );
		}
		catch ( UnresolvedRequest $ex )
		{
			$this->assertSame( $routeRequest, $ex->getDestinationInfo() );
		}
		catch ( \Throwable $throwable )
		{
			$this->fail( 'Wrong exception thrown' );
		}
	}
}
