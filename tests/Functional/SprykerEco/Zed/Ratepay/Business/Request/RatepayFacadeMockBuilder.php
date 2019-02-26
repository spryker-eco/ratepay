<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business\Request;

use Generated\Shared\Transfer\RatepayRequestTransfer;
use PHPUnit_Framework_TestCase;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Ratepay\Business\RatepayBusinessFactory;
use SprykerEco\Zed\Ratepay\Business\RatepayFacade;
use SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainer;
use SprykerEco\Zed\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\RatepayDependencyProvider;

class RatepayFacadeMockBuilder
{
    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface $adapter
     * @param \PHPUnit_Framework_TestCase $testCase
     *
     * @return \SprykerEco\Zed\Ratepay\Business\RatepayFacade
     */
    public function build(AdapterInterface $adapter, PHPUnit_Framework_TestCase $testCase)
    {
        // Mock business factory to override return value of createExecutionAdapter to
        // place a mocked adapter that doesn't establish an actual connection.
        $businessFactoryMock = $this->getBusinessFactoryMock($adapter, $testCase);

        // Business factory always requires a valid query container. Since we're creating
        // functional/integration tests there's no need to mock the database layer.
        $queryContainer = new RatepayQueryContainer();
        $businessFactoryMock->setQueryContainer($queryContainer);

        $container = new Container();
        $ratepayDependencyProvider = new RatepayDependencyProvider();
        $ratepayDependencyProvider->provideBusinessLayerDependencies($container);

        $businessFactoryMock->setContainer($container);

        // Mock the facade to override getFactory() and have it return out
        // previously created mock.
        $facade = $testCase->getMockBuilder(RatepayFacade::class)->setMethods(['getFactory'])->getMock();

        $facade->expects($testCase->any())
            ->method('getFactory')
            ->will($testCase->returnValue($businessFactoryMock));

        return $facade;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface $adapter
     * @param \PHPUnit_Framework_TestCase $testCase
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Ratepay\Business\RatepayBusinessFactory
     */
    protected function getBusinessFactoryMock(AdapterInterface $adapter, PHPUnit_Framework_TestCase $testCase)
    {
        $businessFactoryMock = $testCase->getMockBuilder(RatepayBusinessFactory::class)->setMethods(
            ['createAdapter', 'createRequestTransfer']
        )->getMock();

        $businessFactoryMock->setConfig(new RatepayConfig());
        $businessFactoryMock
            ->expects($testCase->any())
            ->method('createAdapter')
            ->will($testCase->returnValue($adapter));
        $businessFactoryMock
            ->expects($testCase->any())
            ->method('createRequestTransfer')
            ->will($testCase->returnValue($this->createRequestTransfer()));

        return $businessFactoryMock;
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected function createRequestTransfer()
    {
        return new RatepayRequestTransfer();
    }
}
