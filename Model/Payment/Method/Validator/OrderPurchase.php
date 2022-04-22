<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Payment\Method\Validator;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Validator\ValidatorInterface;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

/**
 * Class OrderPurchase
 * @package Punchout2Go\PurchaseOrder\Model\Payment\Method\Validator
 */
class OrderPurchase implements ValidatorInterface
{
    /**
     * @var ResultInterfaceFactory
     */
    protected $resultFactory;

    /**
     * @param ResultInterfaceFactory $resultFactory
     */
    public function __construct(ResultInterfaceFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param array $validationSubject
     * @return \Magento\Payment\Gateway\Validator\ResultInterface|void
     */
    public function validate(array $validationSubject)
    {
        $payment = SubjectReader::readPayment($validationSubject)->getPayment();
        $result = [
            'isValid' => $payment->getQuote()->getExtensionAttributes()->getIsPurchaseOrder(),
            'failsDescription' => []
        ];
        return $this->resultFactory->create($result);
    }
}
