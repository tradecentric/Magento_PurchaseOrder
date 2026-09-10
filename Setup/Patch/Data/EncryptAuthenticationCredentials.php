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
 */
class EncryptAuthenticationCredentials implements DataPatchInterface
{
    private const PATHS = [
        'punchout2go_purchaseorder/authentication/api_key',
        'punchout2go_purchaseorder/authentication/shared_secret',
    ];

    /**
     * Shape produced by \Magento\Framework\Encryption\Encryptor::encrypt(): "<keyVersion>:<cipherVersion>:<iv>:<data>".
     * A plaintext value stored by this module (e.g. "abcd1234") will never match it.
     */
    private const ENCRYPTED_VALUE_PATTERN = '/^\d+:\d+:.+$/';

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

        foreach (self::PATHS as $path) {
            $rows = $connection->fetchAll(
                $connection->select()
                    ->from($table, ['config_id', 'value'])
                    ->where('path = ?', $path)
            );

            foreach ($rows as $row) {
                $value = (string) $row['value'];

                if ($value === '' || preg_match(self::ENCRYPTED_VALUE_PATTERN, $value)) {
                    // Nothing to do: empty, or already encrypted (idempotent - safe to run again).
                    continue;
                }

                $connection->update(
                    $table,
                    ['value' => $this->encryptor->encrypt($value)],
                    ['config_id = ?' => $row['config_id']]
                );
            }
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
