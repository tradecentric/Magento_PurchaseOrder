<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Magento\Framework\Exception\ValidatorException;
use Punchout2Go\PurchaseOrder\Api\Data\QuoteItemInterface;

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
     * @var string
     */
    protected $supplierIdPattern = "/^([^\/]+)\/([^\/]+)$/";

    /**
     * @var null|int
     */
    protected $magentoQuoteId = null;

    /**
     * @var null|int
     */
    protected $magentoItemId = null;

    /**
     * QuoteItem constructor.
     * @param int $line_number
     * @param string $requested_delivery_date
     * @param int $quantity
     * @param string $supplier_id
     * @param string $supplier_aux_id
     * @param float $unit_price
     * @param string $currency
     * @param string $description
     * @param string $uom
     * @param string $comments
     * @param string $session_key
     * @param int $cart_position
     */
    public function __construct(
        int $line_number,
        string $requested_delivery_date,
        int $quantity,
        string $supplier_id,
        string $supplier_aux_id,
        float $unit_price,
        string $currency,
        string $description,
        string $uom,
        string $comments,
        string $session_key,
        int $cart_position
    ) {
        $this->lineNumber = $line_number;
        $this->requestedDeliveryDate = $requested_delivery_date;
        $this->quantity = $quantity;
        $this->supplierId = $supplier_id;
        $this->setSupplierAuxId($supplier_aux_id);
        $this->unitPrice = $unit_price;
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
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     */
    public function setLineNumber(int $lineNumber): void
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
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
        $this->assertNotEmpty($supplierAuxId);
        $this->supplierAuxId = $supplierAuxId;
        $this->magentoItemId = $this->magentoQuoteId = null;

    }

    /**
     * @return int
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice(float $unitPrice): void
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
     * @return int
     */
    public function getCartPosition(): int
    {
        return $this->cartPosition;
    }

    /**
     * @param int $cartPosition
     */
    public function setCartPosition(int $cartPosition): void
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
        list($quoteId,) = $this->parseSupplierAuxId($this->getSupplierAuxId());
        $this->magentoQuoteId = (int) $quoteId;
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
        list(, $itemId) = $this->parseSupplierAuxId($this->getSupplierAuxId());
        $this->magentoItemId = (int) $itemId;
        return $this->magentoItemId;
    }

    /**
     * @param $value
     * @throws ValidatorException
     */
    protected function assertNotEmpty($value)
    {
        if (empty($value) || (bool) $value) {
            throw new ValidatorException(__("Field %1 is empty", $value));
        }
    }

    /**
     * @param string $value
     * @return string[]
     */
    protected function parseSupplierAuxId(string $value)
    {
        $s = ['', ''];
        if (preg_match($this->supplierIdPattern, $value,$s)) {
            array_shift($s);
        }
        return $s;
    }
}
