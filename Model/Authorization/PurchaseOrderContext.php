<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Authorization;

use Magento\Authorization\Model\UserContextInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutContainerInterface;

/**
 * Class PurchaseOrderContext
 * @package Punchout2Go\PurchaseOrder\Model\Authorization
 */
class PurchaseOrderContext implements UserContextInterface
{
    /**
     * @var PunchoutContainerInterface
     */
    protected $container;

    /**
     * @param PunchoutContainerInterface $container
     */
    public function __construct(PunchoutContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return int|void|null
     */
    public function getUserId()
    {
        return $this->container->isPunchout();
    }

    /**
     * @return int|null
     */
    public function getUserType()
    {
        return $this->container->getUserType();
    }
}
