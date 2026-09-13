<?php
/**
 * JOVEpay return URL after a successful payment.
 */
class JovepaySuccessModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    public function initContent()
    {
        parent::initContent();

        $this->context->smarty->assign(array(
            'jovepay_shop_url' => $this->context->link->getPageLink('index'),
            'jovepay_orders_url' => $this->context->link->getPageLink('history'),
            'jovepay_contact_url' => $this->context->link->getPageLink('contact'),
        ));

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->setTemplate('module:Jovepay/views/templates/front/success.tpl');
        } else {
            $this->setTemplate('success-legacy.tpl');
        }
    }

    public function getBreadcrumbLinks()
    {
        if (!method_exists('ModuleFrontController', 'getBreadcrumbLinks')) {
            return array('links' => array());
        }

        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = array(
            'title' => $this->module->l('Payment successful', 'success'),
            'url' => $this->context->link->getModuleLink($this->module->name, 'success'),
        );

        return $breadcrumb;
    }
}
