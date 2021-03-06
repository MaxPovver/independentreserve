<?php

namespace IndependentReserve\Object;

use Concise\TestCase;
use DateTime;

class OrderBookTest extends TestCase
{
    /**
     * @var OrderBook
     */
    protected $orderBook;

    public function setUp()
    {
        parent::setUp();

        $obj = (object)[
            "BuyOrders" => [
                (object)[
                    "OrderType" => "LimitBid",
                    "Price" => 497.02000000,
                    "Volume" => 0.01000000
                ],
                (object)[
                    "OrderType" => "LimitBid",
                    "Price" => 490.00000000,
                    "Volume" => 1.00000000
                ]
            ],
            "CreatedTimestampUtc" => "2014-08-05T06:42:11.3032208Z",
            "PrimaryCurrencyCode" => "Xbt",
            "SecondaryCurrencyCode" => "Usd",
            "SellOrders" => [
                (object)[
                    "OrderType" => "LimitOffer",
                    "Price" => 500.00000000,
                    "Volume" => 1.00000000
                ],
                (object)[
                    "OrderType" => "LimitOffer",
                    "Price" => 505.00000000,
                    "Volume" => 1.00000000
                ]
            ]
        ];

        $this->order = OrderBook::createFromObject($obj);
    }

    public function testCreatedTimestampIsADateTime()
    {
        $this->assert($this->order->getCreatedTimestamp(), instance_of, '\DateTime');
    }

    public function testFactorySetsCreatedTime()
    {
        $this->assert($this->order->getCreatedTimestamp(), equals, new DateTime("2014-08-05T06:42:11.3032208Z"));
    }

    public function testFactorySetsPrimaryCurrencyCode()
    {
        $this->assert($this->order->getPrimaryCurrencyCode(), equals, 'Xbt');
    }

    public function testFactorySetsSecondaryCurrencyCode()
    {
        $this->assert($this->order->getSecondaryCurrencyCode(), equals, 'Usd');
    }

    public function testBuyOrdersIsAnArray()
    {
        $this->assert($this->order->getBuyOrders(), is_an_array);
    }

    public function testSellOrdersIsAnArray()
    {
        $this->assert($this->order->getSellOrders(), is_an_array);
    }

    public function testFactorySetsSingleBuyOrder()
    {
        $buyOrders = $this->order->getBuyOrders();
        $this->assert($buyOrders[0], instance_of, '\IndependentReserve\Object\SimpleOrder');
    }

    public function testFactorySetsSingleSellOrder()
    {
        $sellOrders = $this->order->getSellOrders();
        $this->assert($sellOrders[0], instance_of, '\IndependentReserve\Object\SimpleOrder');
    }

    public function testFactorySetsAllBuyOrders()
    {
        $buyOrders = $this->order->getBuyOrders();
        $this->assert($buyOrders[1], instance_of, '\IndependentReserve\Object\SimpleOrder');
    }

    public function testFactorySetsAllSellOrders()
    {
        $sellOrders = $this->order->getSellOrders();
        $this->assert($sellOrders[1], instance_of, '\IndependentReserve\Object\SimpleOrder');
    }
}
