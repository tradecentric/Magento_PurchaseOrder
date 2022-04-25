<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Magento\Framework\Exception\ValidatorException;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\QuoteItemInterface;
use Punchout2Go\PurchaseOrder\Helper\Data;

/**
 * @package Punchout2Go\PurchaseOrder\Model\PunchoutQuote
 */
class QuoteItem implements QuoteItemInterface
{
    /**
     * @var int
     */
    protected $lineNumber = 0;

    /**
     * @var string
     */
    protected $requestedDeliveryDate = "";

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * @var string
     */
    protected $supplierId = "";

    /**
     * @var string
     */
    protected $supplierAuxId = "";

    /**
     * @var int
     */
    protected $unitPrice = 0;

    /**
     * @var string
     */
    protected $currency = "";

    /**
     * @var string
     */
    protected $description = "";

    /**
     * @var string
     */
    protected $uom = "";

    /**
     * @var string
     */
    protected $comments = "";

    /**
     * @var string
     */
    protected $sessionKey = "";

    /**
     * @var int
     */
    protected $cartPosition = 0;

    /**
     * @var null|int
     */
    protected $magentoQuoteId = null;

    /**
     * @var null|int
     */
    protected $magentoItemId = null;

    /**
     * @param string $line_number
     * @param string $requested_delivery_date
     * @param string $quantity
     * @param string $supplier_id
     * @param string $supplier_aux_id
     * @param string $unitprice
     * @param string $currency
     * @param string $description
     * @param string $uom
     * @param string $comments
     * @param string $session_key
     * @param string $cart_position
     * @throws ValidatorException
     */
    public function __construct(
        string $line_number,
        string $requested_delivery_date,
        string $quantity,
        string $supplier_id,
        string $supplier_aux_id,
        string $unitprice,
        string $currency,
        string $description,
        string $uom,
        string $comments,
        string $session_key,
        string $cart_position
    ) {
        $this->lineNumber = $line_number;
        $this->requestedDeliveryDate = $requested_delivery_date;
        $this->quantity = $quantity;
        $this->supplierId = $supplier_id;
        $this->setSupplierAuxId($supplier_aux_id);
        $this->unitPrice = $unitprice;
        $this->currency = $currency;
        $this->description = $description;
        $this->uom = $uom;
        $this->comments = $comments;
        $this->sessionKey = $session_key;
        $this->cartPosition = $cart_position;
    }

    /**
     * @return int
     */
    public function getLineNumber(): string
    {
        return $this->lineNumber;
    }

    /**
     * @param string $lineNumber
     */
    public function setLineNumber(string $lineNumber): void
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @return string
     */
    public function getRequestedDeliveryDate(): string
    {
        return $this->requestedDeliveryDate;
    }

    /**
     * @param string $requestedDeliveryDate
     */
    public function setRequestedDeliveryDate(string $requestedDeliveryDate): void
    {
        $this->requestedDeliveryDate = $requestedDeliveryDate;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getSupplierId(): string
    {
        return $this->supplierId;
    }

    /**
     * @param string $supplierId
     */
    public function setSupplierId(string $supplierId): void
    {
        $this->supplierId = $supplierId;
    }

    /**
     * @return string
     */
    public function getSupplierAuxId(): string
    {
        return $this->supplierAuxId;
    }

    /**
     * @param string $supplierAuxId
     * @throws ValidatorException
     */
    public function setSupplierAuxId(string $supplierAuxId): void
    {
        $this->assertNotEmpty($supplierAuxId, 'supplier_aux_id');
        $this->supplierAuxId = $supplierAuxId;
        $this->magentoItemId = $this->magentoQuoteId = null;

    }

    /**
     * @return string
     */
    public function getUnitPrice(): string
    {
        return $this->unitPrice;
    }

    /**
     * @param string $unitPrice
     */
    public function setUnitPrice(string $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getUom(): string
    {
        return $this->uom;
    }

    /**
     * @param string $uom
     */
    public function setUom(string $uom): void
    {
        $this->uom = $uom;
    }

    /**
     * @return string
     */
    public function getComments(): string
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    /**
     * @param string $sessionKey
     */
    public function setSessionKey(string $sessionKey): void
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * @return string
     */
    public function getCartPosition(): string
    {
        return $this->cartPosition;
    }

    /**
     * @param string $cartPosition
     */
    public function setCartPosition(string $cartPosition): void
    {
        $this->cartPosition = $cartPosition;
    }

    /**
     * @return int
     */
    public function getMagentoQuoteId(): int
    {
        if ($this->magentoQuoteId !== null) {
            return $this->magentoQuoteId;
        }
        $this->prepareMagentoData();
        return $this->magentoQuoteId;
    }

    /**
     * @return int
     */
    public function getMagentoItemId(): int
    {
        if ($this->magentoItemId !== null) {
            return $this->magentoItemId;
        }
        $this->prepareMagentoData();
        return $this->magentoItemId;
    }

    /**
     * @param $value
     * @param $field
     * @throws ValidatorException
     */
    protected function assertNotEmpty($value, $field)
    {
        if (empty($value) || !(bool) $value) {
            throw new ValidatorException(__("Field %1 is empty", $field));
        }
    }

    /**
     * parse magento values
     */
    protected function prepareMagentoData()
    {
        list($quoteId, $itemId) = $this->parseSupplierAuxId($this->getSupplierAuxId());
        $this->magentoQuoteId = (int) $quoteId;
        $this->magentoItemId = (int) $itemId;
    }

    /**
     * @param string $value
     * @return string[]
     */
    protected function parseSupplierAuxId(string $value)
    {
        $s = ['', ''];
        if (preg_match(Data::SUPPLIER_ID_PATTERN, $value,$s)) {
            array_shift($s);
        }
        return $s;
    }
}
