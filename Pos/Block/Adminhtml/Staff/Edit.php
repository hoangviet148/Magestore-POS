<?php

namespace Learning\Pos\Block\Adminhtml\Staff;
use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * @var Registry|null
     */
    protected $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Construct of class Edit
     */
    protected function _construct()
    {
        $this->_objectId = "id";
        $this->_blockGroup = "Learning_Pos";
        $this->_controller = "adminhtml_staff";
        parent::_construct();
        $this->buttonList->update("save", "label", __("Save"));
        $this->buttonList->update("delete", "label", __("Delete"));
        $this->buttonList->add(
            "saveandcontinue",
            [
                "label" => __("Save and Continue Edit"),

                "class" => "save",
                "data_attribute" => [
                    "mage-init" => ["button" => ["event" => "saveAndContinueEdit",
                        "target" => "#edit_form"]]
                ]
            ],
            -100
        );
    }

    /**
     * Header of Grid Staff
     *
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry("current_staff")->getId()) {
            return __(
                'Edit Staff TEST',
                $this->escapeHtml($this->coreRegistry->registry("current_staff")->getData("name"))
            );
        } else {
            return __("New Staff");
        }
    }
}
