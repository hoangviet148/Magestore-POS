<?php

namespace Learning\Pos\Block\Adminhtml\Staff\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class FormContract extends Generic implements TabInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        ObjectManagerInterface $objectManager,
        array $data = []
    )
    {
        $this->objectManager = $objectManager;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry("current_staff");
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix("page_");
        $fieldset = $form->addFieldset("base_fieldset", ["legend" => __("Contact")]);
        if ($model->getId()) {
            $fieldset->addField("staff_id", "hidden", ["name" => "staff_id"]);
        }
        $fieldset->addField("name", "text", [
            "label" => __("Name"),
            "class" => "required-entry",
            "required" => true,
            "name" => "name",
            "disabled" => false,
        ]);
        $fieldset->addField("email", "text", [
            "label" => __("Email"),
            "class" => "input-text",
            "name" => "email",
            "disabled" => false,
        ]);
        $fieldset->addField("telephone", "text", [
            "label" => __("Phone"),
            "class" => "input-text",
            "name" => "telephone",
            "disabled" => false,
        ]);
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Method getStaff
     *
     * @return mixed
     */
    public function getStaff()
    {
        return $this->_coreRegistry->registry("current_staff");
    }

    /**
     * Method getPageTitle
     *
     * @return Phrase
     */
    public function getPageTitle()
    {
        return $this->getstaff()->getId() ?
            __('Edit Staff %1', $this->escapeHtml($this->getstaff()->getDisplayName()))
            : __("New Staff");
    }

    /**
     * Method getTabLabel
     *
     * @return Phrase
     */
    public function getTabLabel()
    {
        return __("Contact");
    }

    /**
     * Method getTabTitle
     *
     * @return Phrase
     */
    public function getTabTitle()
    {
        return __("Contact");
    }

    /**
     * Method canShowTab
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Method isHidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }
}
