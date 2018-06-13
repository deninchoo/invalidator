<?php

namespace Inchoo\Invalidator\Block\Backend\Grid;

class ItemsUpdater extends \Magento\Indexer\Block\Backend\Grid\ItemsUpdater
{
    public function update($argument)
    {
        if (false === $this->authorization->isAllowed('Magento_Indexer::changeMode')) {
            unset($argument['change_mode_onthefly']);
            unset($argument['change_mode_changelog']);
        }
        if (false === $this->authorization->isAllowed('Inchoo_Invalidator::invalidateindexers')) {
            unset($argument['change_mode_invalidate']);
        }
        return $argument;
    }
}
