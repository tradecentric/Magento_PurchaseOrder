<?php
declare(strict_types=1);

namespace Punchout2Go\PurchaseOrder\Setup\Patch\Data;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Re-encrypts existing plaintext values at punchout2go_purchaseorder/authentication/api_key and
 * .../shared_secret now that those fields use the Encrypted config backend model.
 *
 * Changing a field's type to "obscure" does not retroactively encrypt what is already stored in
 * core_config_data - without this patch, an existing customer's value would stay in plaintext until
 * the field happened to be re-saved in admin.
 *
 * This intentionally does NOT try to guess whether a value is already encrypted by its shape
 * (e.g. matching "<digits>:<digits>:..."). A real plaintext credential can legitimately match that
 * shape, which would cause it to be skipped and then silently mis-decrypted on every later read.
 *
 * The whole migration runs inside one transaction, so a failure partway through rolls back
 * completely rather than leaving some rows encrypted and others not - a retry (e.g. re-running
 * setup:upgrade after a failed attempt) always starts from a clean, fully-unencrypted state.
 * Idempotency then relies on Magento's own patch tracking (patch_list) guaranteeing apply() runs
 * exactly once per install under normal operation. The one residual risk is someone manually
 * resetting this patch's patch_list entry and re-running it after it already succeeded, which
 * would double-encrypt - a deliberate action outside normal deploy flow, not something a routine
 * failure/retry can trigger.
 */
class EncryptAuthenticationCredentials implements DataPatchInterface
{
    private const PATHS = [
        'punchout2go_purchaseorder/authentication/api_key',
        'punchout2go_purchaseorder/authentication/shared_secret',
    ];

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EncryptorInterface $encryptor
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->encryptor = $encryptor;
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $table = $this->moduleDataSetup->getTable('core_config_data');

        $connection->beginTransaction();
        try {
            foreach (self::PATHS as $path) {
                $rows = $connection->fetchAll(
                    $connection->select()
                        ->from($table, ['config_id', 'value'])
                        ->where('path = ?', $path)
                );

                foreach ($rows as $row) {
                    $value = (string) $row['value'];

                    if ($value === '') {
                        continue;
                    }

                    $connection->update(
                        $table,
                        ['value' => $this->encryptor->encrypt($value)],
                        ['config_id = ?' => $row['config_id']]
                    );
                }
            }
            $connection->commit();
        } catch (\Throwable $e) {
            $connection->rollBack();
            throw $e;
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
