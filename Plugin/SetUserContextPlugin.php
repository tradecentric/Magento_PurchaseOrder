<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Plugin;

use Magento\Authorization\Model\UserContextInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutContainerInterface;
use Punchout2Go\PurchaseOrder\Api\PunchoutOrderManagerInterface;

/**
 * Class SetUserContextPlugin
 * @package Punchout2Go\PurchaseOrder\Plugin
 */
class SetUserContextPlugin
{
    /**
     * @var PunchoutContainerInterface
     */
    protected $container;

    /**
     * @param PunchoutContainerInterface $containerFactory
     */
    public function __construct(PunchoutContainerInterface $containerFactory)
    {
        $this->container = $containerFactory;
    }

    /**
     * @param PunchoutOrderManagerInterface $subject
     */
    public function beforeCreate(
        PunchoutOrderManagerInterface $subject
    ) {
        $this->container->isPunchout(true);
        $this->container->setUserType(UserContextInterface::USER_TYPE_ADMIN);
    }
}
