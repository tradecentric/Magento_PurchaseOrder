<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\PunchoutQuote;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\ExtraAttributeInterface;

class ExtraAttribute implements ExtraAttributeInterface
{
    private $name = '';
    private $value = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ExtraAttributeInterface
     */
    public function setName(string $name): ExtraAttributeInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ExtraAttributeInterface
     */
    public function setValue(string $value): ExtraAttributeInterface
    {
        $this->value = $value;
        return $this;
    }
}
