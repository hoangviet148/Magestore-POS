<?php

namespace Learning\Pos\Block\Adminhtml\Staff\Edit;

use Learning\Pos\Block\Adminhtml\Staff\Edit\Tab\FormContract as FormContract;
use Learning\Pos\Block\Adminhtml\Staff\Edit\Tab\FormGeneralInformation as FormGeneralInformation;


use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\AbstractBlock;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * construct to build object Tabs
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('staff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__("Section"));
    }

    /**
     * Method beforeToHtml
     *
     * @return \Magento\Backend\Block\Widget\Tabs|AbstractBlock
     * @throws Exception
     * @throws LocalizedException
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            [
                'label' => __('General Information'),
                'title' => __('general'),
                'content' => $this->getLayout()->createBlock(
                    FormGeneralInformation::class
                )
                    ->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'contact',
            [
                'label' => __('Contact'),
                'title' => __('contact-staff'),
                'content' => $this->getLayout()->createBlock(
                    FormContract::class
                )
                    ->toHtml()
            ]
        );
        return parent::_beforeToHtml();
    }
}
