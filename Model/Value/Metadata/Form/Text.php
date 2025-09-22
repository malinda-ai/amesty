<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2023 Amasty (https://www.amasty.com)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Amasty\Orderattr\Model\Value\Metadata\Form;

use Magento\Eav\Model\AttributeDataFactory;

class Text extends \Magento\Eav\Model\Attribute\Data\Text
{
    /**
     * Export attribute value to entity model
     *
     * @param array|string $value
     * @return $this
     */
    public function compactValue($value)
    {
        if ($value !== false) {
            /*
             * avoid snake_case to CamelCale and vice versa convertation
             * because underscore in attribute_code can be lost
             */
            $this->getEntity()->setData($this->getAttribute()->getAttributeCode(), $value);
        }
        return $this;
    }

    /**
     * @param string $format
     * @return array|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function outputValue($format = AttributeDataFactory::OUTPUT_FORMAT_TEXT)
    {
        if ($this->getAttribute()->getfrontendInput() === AttributeDataFactory::OUTPUT_FORMAT_HTML) {
            return $this->getAttribute()->getDefaultValue();
        }

        return parent::outputValue($format);
    }
}
