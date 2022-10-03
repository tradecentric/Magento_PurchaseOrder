<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Model\Authorization;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\Webapi\Request;

/**
 * Class PurchaseOrderContext
 * @package Punchout2Go\PurchaseOrder\Model\Authorization
 */
class PurchaseOrderContext implements UserContextInterface
{
    /**
     * @var PunchoutContainerInterface
     */
    protected $request;

    /**
     * @var string
     */
    protected $punchoutPath;

    /**
     * @param Request $request
     * @param string $punchoutPath
     */
    public function __construct(
        Request $request,
        string $punchoutPath = '/V1/purchase-orders'
    ) {
        $this->request = $request;
        $this->punchoutPath = $punchoutPath;
    }

    /**
     * @return int|void|null
     */
    public function getUserId()
    {
        return $this->request->getPathInfo() === $this->punchoutPath;
    }

    /**
     * @return int|null
     */
    public function getUserType()
    {
        return UserContextInterface::USER_TYPE_INTEGRATION;
    }
}
