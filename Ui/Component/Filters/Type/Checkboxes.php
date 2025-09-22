<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2023 Amasty (https://www.amasty.com)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Amasty\Orderattr\Ui\Component\Filters\Type;

use Magento\Ui\Component\Form\Element\Select as ElementSelect;

class Checkboxes extends \Magento\Ui\Component\Filters\Type\Select
{

    public const NAME = 'filter_checkboxes';

    public const COMPONENT = 'checkboxes';

    /**
     * @var ElementSelect
     */
    protected $wrappedComponent;

    /**
     * Apply filter
     *
     * @return void
     */
    protected function applyFilter()
    {
        if (isset($this->filterData[$this->getName()])) {
            $value = sprintf('%%%s%%', $this->filterData[$this->getName()]);
            $conditionType = 'like';

            if (!empty($value) || is_numeric($value)) {
                $filter = $this->filterBuilder->setConditionType($conditionType)
                    ->setField($this->getName())
                    ->setValue($value)
                    ->create();

                $this->getContext()->getDataProvider()->addFilter($filter);
            }
        }
    }
}
