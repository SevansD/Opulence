<?php
/**
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2016 David Young
 * @license   https://github.com/opulencephp/Opulence/blob/master/LICENSE.md
 */
namespace Opulence\Authentication\Tokens\JsonWebTokens\Verification;

use DateTimeImmutable;
use Opulence\Authentication\Tokens\JsonWebTokens\JwtPayload;
use Opulence\Authentication\Tokens\JsonWebTokens\SignedJwt;

/**
 * Tests the expiration verifier
 */
class ExpirationVerifierTest extends \PHPUnit_Framework_TestCase
{
    /** @var ExpirationVerifier The verifier to use in tests */
    private $verifier = null;
    /** @var SignedJwt|\PHPUnit_Framework_MockObject_MockObject The token to use in tests */
    private $jwt = null;
    /** @var JwtPayload|\PHPUnit_Framework_MockObject_MockObject The payload to use in tests */
    private $jwtPayload = null;

    /**
     * Sets up the tests
     */
    public function setUp()
    {
        $this->verifier = new ExpirationVerifier();
        $this->jwt = $this->getMock(SignedJwt::class, [], [], "", false);
        $this->jwtPayload = $this->getMock(JwtPayload::class);
        $this->jwt->expects($this->any())
            ->method("getPayload")
            ->willReturn($this->jwtPayload);
    }

    /**
     * Tests that an exception is thrown on an expired token
     */
    public function testExceptionThrownOnExpiredToken()
    {
        $this->setExpectedException(VerificationException::class);
        $date = new DateTimeImmutable("-30 second");
        $this->jwtPayload->expects($this->once())
            ->method("getValidTo")
            ->willReturn($date);
        $this->verifier->verify($this->jwt);
    }

    /**
     * Tests verifying valid token
     */
    public function testVerifyingValidToken()
    {
        $date = new DateTimeImmutable("+30 second");
        $this->jwtPayload->expects($this->once())
            ->method("getValidTo")
            ->willReturn($date);
        $this->verifier->verify($this->jwt);
    }
}