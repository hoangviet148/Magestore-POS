<?php


namespace Learning\Pos\Block\Adminhtml\Staff\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class FormGeneralInformation extends Generic implements TabInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     *
     * 44
     * @param ObjectManagerInterface $objectManager
     * @param array $data
     */
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

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock("page.title")->setPageTitle($this->getPageTitle());
    }

    /**
     * Method _prepareForm
     *
     * @return $this
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry("current_staff");
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix("page_");
        $fieldset = $form->addFieldset("base_fieldset", ["legend" => __("General Information")]);
        if ($model->getId()) {
            $fieldset->addField("id", "hidden", ["name" => "id"]);
        }
        $fieldset->addField("username", "text", [
            "label" => __("Username"),
            "class" => "required-entry",
            "required" => true,
            "name" => "username",
            "disabled" => false,
        ]);
        if ($model->getId()) {
            $fieldset->addField("password", "password", [
                "label" => __("Password"),
                "class" => "input-text",
                "name" => "password",
                "disabled" => false,
            ]);
            $fieldset->addField("password_confirmation", "password", [
                "label" => __("Password Confirmation"),
                "class" => "input-text",
                "name" => "password_confirmation",
                "disabled" => false,
            ]);
        } else {
            $fieldset->addField("password", "password", [
                "label" => __("Password"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password",
                "disabled" => false,
            ]);
            $fieldset->addField("password_confirmation", "password", [
                "label" => __("Password Confirmation"),
                "class" => "required-entry",
                "required" => true,
                "name" => "password_confirmation",
                "disabled" => false,
            ]);
        }
        $fieldset->addField("status", "select", [
            "label" => __("Status"),
            "class" => "required-entry",
            "required" => true,
            "name" => "status",
            "options" => [
                0 => "Disabled",
                1 => "Enabled"
            ],
            "disabled" => false,
        ]);
        $model->setData("password_confirmation", $model->getPassword());
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

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
        return $this->getstaff()->getId() ? __(
            'Edit Staff %1',
            $this->escapeHtml($this->getstaff()->getDisplayName())
        ) : __("New Staff");
    }

    /**
     * Method getTabLabel
     *
     * @return Phrase
     */
    public function getTabLabel()
    {
        return __("General Information");
    }

    /**
     * Method getTabTitle
     *
     * @return Phrase
     */
    public function getTabTitle()
    {
        return __("General Information");
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
