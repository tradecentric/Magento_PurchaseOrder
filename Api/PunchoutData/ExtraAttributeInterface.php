<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Api\PunchoutData;

interface ExtraAttributeInterface
{
    /**
     * @param string $name
     * @return ExtraAttributeInterface
     */
    public function setName(string $name): ExtraAttributeInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $value
     * @return ExtraAttributeInterface
     */
    public function setValue(string $value): ExtraAttributeInterface;

    /**
     * @return string
     */
    public function getValue(): string;
}
