<?php declare(strict_types=1);

namespace XrplConnector\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(XrplTxEntity $entity)
 * @method void                set(string $key, XrplTxEntity $entity)
 * @method XrplTxEntity[]      getIterator()
 * @method XrplTxEntity[]      getElements()
 * @method XrplTxEntity|null   get(string $key)
 * @method XrplTxEntity|null   first()
 * @method XrplTxEntity|null   last()
 */
class XrplTxCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return XrplTxEntity::class;
    }
}