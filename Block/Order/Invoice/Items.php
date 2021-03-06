<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Sales order view items block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Dealer4Dealer\SubstituteOrders\Block\Order\Invoice;

class Items extends \Magento\Sales\Block\Items\AbstractItems
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $_orderRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * @param Magento order id $id
     * @return order
     */
    public function getOrderById($id) {
        return $this->_orderRepository->get($id);
    }

    /**
     * @param object $invoice
     * @return string
     */
    public function getPrintInvoiceUrl($invoice)
    {
        return $this->getUrl('*/*/printInvoice', ['id' => $this->getOrder()->getId()]);
    }

    /**
     * @param object $order
     * @return string
     */
    public function getPrintAllInvoicesUrl($order)
    {
        return $this->getUrl('*/*/printInvoice', ['id' => $order->getId()]);
    }

    /**
     * Get html of invoice totals block
     *
     * @param   \Magento\Sales\Model\Order\Invoice $invoice
     * @return  string
     */
    public function getInvoiceTotalsHtml($invoice)
    {
        $html = '';
        $totals = $this->getChildBlock('invoice_totals');
        if ($totals) {
            $totals->setInvoice($invoice);
            $html = $totals->toHtml();
        }
        return $html;
    }

    /**
     * Get html of invoice comments block
     *
     * @param   \Magento\Sales\Model\Order\Invoice $invoice
     * @return  string
     */
    public function getInvoiceCommentsHtml($invoice)
    {
        $html = '';
        $comments = $this->getChildBlock('invoice_comments');
        if ($comments) {
            $comments->setEntity($invoice)->setTitle(__('About Your Invoice'));
            $html = $comments->toHtml();
        }
        return $html;
    }

    /**
     * Get html of invoice comments block
     *
     * @param   \Magento\Sales\Model\Order\Invoice $invoice
     * @return  string
     */
    public function getInvoiceAttachmentHtml($invoice)
    {
        $html = '';
        $comments = $this->getChildBlock('invoice_attachments');
        if ($comments) {
            $comments->setEntity($invoice)->setTitle(__('Invoice Attachments'));
            $html = $comments->toHtml();
        }
        return $html;
    }
}
