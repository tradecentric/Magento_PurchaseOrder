<?php

namespace Punchout2Go\PurchaseOrder\Model\Service;

use Punchout2Go\PurchaseOrder\Api\PunchoutData\PunchoutQuoteInterface;

class PunchoutQuoteService
{
    protected ?PunchoutQuoteInterface $punchoutQuote = null;

    /**
     * @return PunchoutQuoteInterface|null
     */
    public function getPunchoutQuote(): ?PunchoutQuoteInterface
    {
        return $this->punchoutQuote;
    }

    /**
     * @param PunchoutQuoteInterface|null $punchoutQuote
     */
    public function setPunchoutQuote(?PunchoutQuoteInterface $punchoutQuote): void
    {
        $this->punchoutQuote = $punchoutQuote;
    }

}