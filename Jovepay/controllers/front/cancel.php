<?php
/**
 * JOVEpay return URL after a cancelled or failed payment.
 */
class JovepayCancelModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    public function initContent()
    {
        parent::initContent();

        $cartParams = array('action' => 'show');
        $cartUrl = $this->context->link->getPageLink('order');
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $cartUrl = $this->context->link->getPageLink('cart', null, null, $cartParams);
        }

        $this->context->smarty->assign(array(
            'jovepay_shop_url' => $this->context->link->getPageLink('index'),
            'jovepay_cart_url' => $cartUrl,
            'jovepay_contact_url' => $this->context->link->getPageLink('contact'),
        ));

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->setTemplate('module:Jovepay/views/templates/front/failure.tpl');
        } else {
            $this->setTemplate('failure-legacy.tpl');
        }
    }

    public function getBreadcrumbLinks()
    {
        if (!method_exists('ModuleFrontController', 'getBreadcrumbLinks')) {
            return array('links' => array());
        }

        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = array(
            'title' => $this->module->l('Payment failed', 'cancel'),
            'url' => $this->context->link->getModuleLink($this->module->name, 'cancel'),
        );

        return $breadcrumb;
    }
}
