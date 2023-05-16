<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Magento\Framework\Exception\ValidatorException;
use Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface;
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
     * @var array
     */
    protected $extraData = [];

    protected $fixed_product_tax = [];

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
     * @param array $extra_data
     * @param array $fixed_product_tax
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
        string $cart_position,
        array $extra_data = [],
        array $fixed_product_tax = []
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
        $this->extraData = $extra_data;
        $this->fixed_product_tax = $fixed_product_tax;
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
     * @return QuoteItemInterface
     */
    public function setLineNumber(string $lineNumber): QuoteItemInterface
    {
        $this->lineNumber = $lineNumber;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setRequestedDeliveryDate(string $requestedDeliveryDate): QuoteItemInterface
    {
        $this->requestedDeliveryDate = $requestedDeliveryDate;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setQuantity(string $quantity): QuoteItemInterface
    {
        $this->quantity = $quantity;
        return $this;
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
    public function setSupplierId(string $supplierId): QuoteItemInterface
    {
        $this->supplierId = $supplierId;
        return $this;
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
     * @return QuoteItemInterface
     * @throws ValidatorException
     */
    public function setSupplierAuxId(string $supplierAuxId): QuoteItemInterface
    {
        $this->assertNotEmpty($supplierAuxId, 'supplier_aux_id');
        $this->supplierAuxId = $supplierAuxId;
        $this->magentoItemId = $this->magentoQuoteId = null;
        return $this;

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
     * @return QuoteItemInterface
     */
    public function setUnitPrice(string $unitPrice): QuoteItemInterface
    {
        $this->unitPrice = $unitPrice;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setCurrency(string $currency): QuoteItemInterface
    {
        $this->currency = $currency;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setDescription(string $description): QuoteItemInterface
    {
        $this->description = $description;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setUom(string $uom): QuoteItemInterface
    {
        $this->uom = $uom;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setComments(string $comments): QuoteItemInterface
    {
        $this->comments = $comments;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setSessionKey(string $sessionKey): QuoteItemInterface
    {
        $this->sessionKey = $sessionKey;
        return $this;
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
     * @return QuoteItemInterface
     */
    public function setCartPosition(string $cartPosition): QuoteItemInterface
    {
        $this->cartPosition = $cartPosition;
        return $this;
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
     * @return ExtraAttributeInterface[]
     */
    public function getExtraData(): array
    {
        return $this->extraData;
    }

    /**
     * @param ExtraAttributeInterface[] $extra_data
     * @return QuoteItemInterface
     */
    public function setExtraData(array $extra_data): QuoteItemInterface
    {
        $this->extraData = $extra_data;
        return $this;
    }

    /**
     * @return ExtraAttributeInterface[]
     */
    public function getFixedProductTax(): array
    {
        return $this->fixed_product_tax;
    }

    /**
     * @param ExtraAttributeInterface[] $fixedProductTax
     * @return QuoteItemInterface
     */
    public function setFixedProductTax(array $fixedProductTax): QuoteItemInterface
    {
        $this->fixed_product_tax = $fixedProductTax;
        return $this;
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

        if (!is_array($s) || count($s) < 2) {
            throw new ValidatorException(__("Incorrect data in supplierAuxId. Value: $value."));
        }

        return $s;
    }
}
