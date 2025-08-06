<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Checkout;

use Magento\Customer\Api\Data\GroupInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Punchout2Go\PurchaseOrder\Api\Checkout\CartManagementInterface;
use Magento\Quote\Api\CartManagementInterface as MagentoCartManagement;

/**
 * Class CartManagement
 * @package Punchout2Go\PurchaseOrder\Model\Checkout
 */
class CartManagement implements CartManagementInterface
{
    /**
     * @var MagentoCartManagement
     */
    protected $cartManagement;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @param MagentoCartManagement $cartManagement
     * @param EventManager $eventManager
     */
    public function __construct(
        MagentoCartManagement $cartManagement,
        EventManager $eventManager
    ) {
        $this->cartManagement = $cartManagement;
        $this->eventManager = $eventManager;
    }

    /**
     * @param CartInterface $quote
     * @param PaymentInterface|null $paymentMethod
     * @return OrderInterface
     * @throws LocalizedException
     */
    public function placeOrderForQuote(CartInterface $quote, ?PaymentInterface $paymentMethod = null): OrderInterface
    {
        if ($paymentMethod) {
            $paymentMethod->setChecks(
                [
                    \Magento\Payment\Model\MethodInterface::CHECK_USE_CHECKOUT,
                    \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_COUNTRY,
                    \Magento\Payment\Model\MethodInterface::CHECK_USE_FOR_CURRENCY,
                    \Magento\Payment\Model\MethodInterface::CHECK_ORDER_TOTAL_MIN_MAX,
                    \Magento\Payment\Model\MethodInterface::CHECK_ZERO_TOTAL
                ]
            );
            $quote->getPayment()->setQuote($quote);

            $data = $paymentMethod->getData();
            $quote->getPayment()->importData($data);
        } else {
            $quote->collectTotals();
        }

        if ($quote->getCheckoutMethod() === MagentoCartManagement::METHOD_GUEST) {
            $quote->setCustomerId(null);
            $quote->setCustomerEmail($quote->getBillingAddress()->getEmail());
            if ($quote->getCustomerFirstname() === null && $quote->getCustomerLastname() === null) {
                $quote->setCustomerFirstname($quote->getBillingAddress()->getFirstname());
                $quote->setCustomerLastname($quote->getBillingAddress()->getLastname());
                if ($quote->getBillingAddress()->getMiddlename() === null) {
                    $quote->setCustomerMiddlename($quote->getBillingAddress()->getMiddlename());
                }
            }
            $quote->setCustomerIsGuest(true);
            $groupId = $quote->getCustomer()->getGroupId() ?: GroupInterface::NOT_LOGGED_IN_ID;
            $quote->setCustomerGroupId($groupId);
        }

        $this->eventManager->dispatch('punchout_checkout_submit_before', ['quote' => $quote]);

        $order = $this->cartManagement->submit($quote);

        if (null == $order) {
            throw new LocalizedException(
                __('A server error stopped your order from being placed. Please try to place your order again.')
            );
        }

        $this->eventManager->dispatch('punchout_checkout_submit_all_after', ['order' => $order, 'quote' => $quote]);
        return $order;
    }
}
