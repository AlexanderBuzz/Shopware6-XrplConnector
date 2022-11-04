<?php declare(strict_types=1);

namespace XrplConnector\Entity;

use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class TransactionDefinition extends EntityDefinition
{

    public const ENTITY_NAME = 'saferpaysw6_transaction';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),

            (new FkField('order_id', 'orderId', OrderDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(OrderDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new OneToOneAssociationField('order', 'order_id', 'id', OrderDefinition::class, false),

            (new StringField('xrpl_transaction_id', 'xrplTransactionId')),

            new CreatedAtField(),
            new UpdatedAtField(),

            new OneToOneAssociationField('order', 'order_id', 'id', OrderDefinition::class, false)
        ]);
    }

    public function getEntityClass(): string
    {
        return TransactionEntity::class;
    }

    public function getCollectionClass(): string
    {
        return TransactionCollection::class;
    }
}