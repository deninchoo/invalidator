<?php

namespace Inchoo\Invalidator\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Indexer\IndexerRegistry;

class InvalidateIndexers extends Action
{
    protected function _isAllowed()
    {
        if ($this->_request->getActionName() == 'invalidateIndexers') {
            return $this->_authorization->isAllowed('Inchoo_Invalidator::invalidateindexers');
        }
        return false;
    }

    /**
     * @var IndexerRegistry
     */
    private $indexerRegistry;

    public function __construct(
        Context $context,
        IndexerRegistry $indexerRegistry
    ) {
        $this->indexerRegistry = $indexerRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $indexerIds = $this->getRequest()->getParam('indexer_ids');
        foreach ($indexerIds as $indexerId) {
            try {
                $indexer = $this->indexerRegistry->get($indexerId);
                $indexer->invalidate();
                $this->messageManager->addSuccess(
                    '<div class="inchoo-invalidate-info">'
                    . $indexer->getTitle() . ' index has been invalidated successfully' . '</div>'
                );
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __("Indexers could not be invalidated due to an error.")
                );
            }
        }
        $this->_redirect('indexer/indexer/list');
    }
}
