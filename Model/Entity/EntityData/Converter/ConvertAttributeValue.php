<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) 2023 Amasty (https://www.amasty.com)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Amasty\Orderattr\Model\Entity\EntityData\Converter;

use Amasty\Orderattr\Api\Data\AttributeValueInterface;
use Amasty\Orderattr\Api\Data\AttributeValueInterfaceFactory;
use Magento\Framework\Api\AttributeInterface;
use Magento\Store\Model\Store;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class ConvertAttributeValue
{
    /**
     * @var CanConvertAttributeValue
     */
    private $canConvertAttributeValue;

    /**
     * @var GetOptionLabels
     */
    private $getOptionLabels;

    /**
     * @var AttributeValueInterfaceFactory
     */
    private $attributeValueFactory;

    public function __construct(
        CanConvertAttributeValue $canConvertAttributeValue,
        GetOptionLabels $getOptionLabels,
        AttributeValueInterfaceFactory $attributeValueFactory
    ) {
        $this->canConvertAttributeValue = $canConvertAttributeValue;
        $this->getOptionLabels = $getOptionLabels;
        $this->attributeValueFactory = $attributeValueFactory;
    }

    public function execute(AttributeInterface $attributeValue): AttributeValueInterface
    {
        if (!$this->canConvertAttributeValue->execute($attributeValue->getAttributeCode())) {
            return $this->attributeValueFactory->create()
                ->setAttributeCode($attributeValue->getAttributeCode())
                ->setValue($attributeValue->getValue());
        }

        $optionIds = explode(',', $attributeValue->getValue());

        return $this->attributeValueFactory->create()
            ->setAttributeCode($attributeValue->getAttributeCode())
            ->setValue($attributeValue->getValue())
            ->setLabel($this->getLabelValue($optionIds));
    }

    private function getLabelValue(array $optionIds): ?string
    {
        $optionLabels = $this->getOptionLabels->execute();

        $labels = [];
        foreach ($optionIds as $optionId) {
            $optionLabel = $this->getOptionLabel($optionLabels, (int) $optionId);
            if (!$optionLabel) {
                return null;
            }

            $labels[] = $optionLabel;
        }

        return implode(',', $labels);
    }

    private function getOptionLabel(array $optionLabels, int $optionId): ?string
    {
        return $optionLabels[$optionId][Store::DEFAULT_STORE_ID] ?? null;
    }
}
