<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request;

use SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\BaseResponse;
use SprykerEco\Zed\Ratepay\Business\Exception\NoMethodMapperException;
use SprykerEco\Zed\Ratepay\Business\Log\LoggerTrait;
use SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface;

abstract class TransactionHandlerAbstract implements TransactionHandlerInterface
{
    use LoggerTrait;

    const TRANSACTION_TYPE = null;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface
     */
    protected $executionAdapter;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactoryInterface
     */
    protected $converterFactory;

    /**
     * @var \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @var array
     */
    protected $methodMappers = [];

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface $executionAdapter
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactoryInterface $converterFactory
     * @param \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface $queryContainer
     */
    public function __construct(
        AdapterInterface $executionAdapter,
        ConverterFactoryInterface $converterFactory,
        RatepayQueryContainerInterface $queryContainer
    ) {
        $this->executionAdapter = $executionAdapter;
        $this->converterFactory = $converterFactory;
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param string $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\BaseResponse
     */
    protected function sendRequest($request)
    {
        return new BaseResponse($this->executionAdapter->sendRequest($request));
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface $mapper
     *
     * @return void
     */
    public function registerMethodMapper(RequestMethodInterface $mapper)
    {
        $this->methodMappers[$mapper->getMethodName()] = $mapper;
    }

    /**
     * @param string $method
     *
     * @throws \SprykerEco\Zed\Ratepay\Business\Exception\NoMethodMapperException
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\MethodInterface|\SprykerEco\Zed\Ratepay\Business\Request\Service\Method\MethodInterface
     */
    protected function getMethodMapper($method)
    {
        if (isset($this->methodMappers[$method]) === false) {
            throw new NoMethodMapperException(sprintf("The method %s mapper is not registered.", $method));
        }

        return $this->methodMappers[$method];
    }
}
