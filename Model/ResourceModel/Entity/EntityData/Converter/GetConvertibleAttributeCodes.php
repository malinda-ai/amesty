<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2023 Amasty (https://www.amasty.com)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Amasty\Orderattr\Model\ResourceModel\Entity\EntityData\Converter;

use Amasty\Orderattr\Model\ResourceModel\Entity\Entity as EntityResource;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Framework\App\ResourceConnection;

class GetConvertibleAttributeCodes
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param string[] $frontendInputs Convertible frontend inputs
     * @return string[]
     */
    public function execute(array $frontendInputs): array
    {
        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select()
            ->from(
                ['attr' => $this->resourceConnection->getTableName('eav_attribute')],
                [AttributeInterface::ATTRIBUTE_CODE]
            )
            ->joinInner(
                ['entity_type' => $this->resourceConnection->getTableName('eav_entity_type')],
                'attr.entity_type_id = entity_type.entity_type_id',
                []
            )
            ->where('entity_type.entity_type_code = ?', EntityResource::ENTITY_TYPE_CODE)
            ->where('attr.frontend_input in (?)', $frontendInputs);

        return $connection->fetchCol($select);
    }
}
