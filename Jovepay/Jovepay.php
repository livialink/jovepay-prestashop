<?php

/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Jovepay extends PaymentModule
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'Jovepay';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'JOVEpay';
        $this->need_instance = 0;

        /** Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6) */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('JOVEpay Crypto Payments');
        $this->description = $this->l('Accept USDT,BTC, ETH, BNB, LTC, and many more,giving customers the freedom to pay with the crypto they trust.');
        $this->confirmUninstall = $this->l('Are you sure of uninstalling JOVEpay Crypto Payments? All your settings will be lost.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        if (extension_loaded('curl') == false) {
            $this->_errors[] = $this->l('You have to enable the cURL extension on your server to install this module');
            return false;
        }

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('payment') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('displayPaymentReturn') &&
            $this->registerHook('paymentOptions');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /** If values have been submitted in the form, process. */
        if (((bool) Tools::isSubmit('submitJovepayModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        return $this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitJovepayModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),  /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('JOVEpay Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mainnet/ Testnet mode'),
                        'name' => 'JOVEPAY_TESTNET_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in mainnet/ testnet mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => false,
                                'label' => $this->l('Mainnet')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => true,
                                'label' => $this->l('Testnet')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Light/ Dark theme'),
                        'name' => 'JOVEPAY_DARK_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Set the payment widget theme'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Light')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Dark')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('This controls the title which the user sees during checkout.'),
                        'name' => 'JOVEPAY_TITLE',
                        'label' => $this->l('Title'),
                    ),
                    array(
                        'col' => 5,
                        'type' => 'text',
                        'desc' => $this->l('This controls the description which the user sees during checkout.'),
                        'name' => 'JOVEPAY_DESC',
                        'label' => $this->l('Description'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Please enter your jovepay.com IPN Secret.'),
                        'suffix' => '<a target="_blank" href="https://app.jovepay.com/en/webhooks-settings">Get it</a>',
                        'name' => 'JOVEPAY_IPN_SECRET',
                        'label' => $this->l('IPN Secret'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Please enter your jovepay.com Api Key.'),
                        'suffix' => '<a target="_blank" href="https://app.jovepay.com/en/apikey-settings">Get it</a>',
                        'name' => 'JOVEPAY_API_KEY',
                        'label' => $this->l('Api Key'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Please enter a prefix for your invoice numbers. If you use your jovepay.com account for multiple stores ensure this prefix is unique.'),
                        'name' => 'JOVEPAY_INPREF',
                        'label' => $this->l('Invoice Prefix'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'JOVEPAY_TESTNET_MODE' => Configuration::get('JOVEPAY_TESTNET_MODE', true),
            'JOVEPAY_DARK_MODE' => Configuration::get('JOVEPAY_DARK_MODE', true),
            'JOVEPAY_TITLE' => Configuration::get('JOVEPAY_TITLE', ''),
            'JOVEPAY_DESC' => Configuration::get('JOVEPAY_DESC', ''),
            'JOVEPAY_IPN_SECRET' => Configuration::get('JOVEPAY_IPN_SECRET', ''),
            'JOVEPAY_API_KEY' => Configuration::get('JOVEPAY_API_KEY', ''),
            'JOVEPAY_INPREF' => Configuration::get('JOVEPAY_INPREF', ''),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Add the CSS / JS files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');
        $this->context->controller->addJS($this->_path . 'views/js/front.js');
    }

    /**
     * Crypto coin icons shown beside the gateway title at checkout.
     *
     * @return array<int, array{id: string, src: string, alt: string, z_index: int}>
     */
    public function getCheckoutCoinIcons()
    {
        $base = $this->_path . 'images/coins/';
        $icons = array(
            array(
                'id' => 'btc',
                'src' => $base . 'btc.png',
                'alt' => 'Bitcoin',
            ),
            array(
                'id' => 'eth',
                'src' => $base . 'eth.png',
                'alt' => 'Ethereum',
            ),
            array(
                'id' => 'usdt',
                'src' => $base . 'usdt.png',
                'alt' => 'Tether',
            ),
            array(
                'id' => 'bnb',
                'src' => $base . 'bnb.png',
                'alt' => 'BNB',
            ),
        );

        $total = count($icons);
        foreach ($icons as $index => &$icon) {
            $icon['z_index'] = $total - $index;
        }
        unset($icon);

        return $icons;
    }

    /**
     * Checkout title shown on the payment option (falls back to JOVEpay).
     *
     * @return string
     */
    public function getCheckoutTitle()
    {
        $title = Configuration::get('JOVEPAY_TITLE');

        if (!is_string($title) || Tools::strlen(trim($title)) === 0) {
            return $this->l('JOVEpay');
        }

        return $title;
    }

    /**
     * Absolute module asset URL for checkout (logo / coins).
     *
     * @param string $relativePath Path under the module root
     *
     * @return string
     */
    protected function getModuleAssetUrl($relativePath)
    {
        return $this->_path . ltrim($relativePath, '/');
    }

    /**
     * Render logo + title + stacked coin label for the checkout Pay button.
     *
     * @return string
     */
    protected function renderPaymentOptionLabel()
    {
        $this->context->smarty->assign(array(
            'jovepay_logo' => $this->getModuleAssetUrl('images/logo.svg'),
            'jovepay_title' => $this->getCheckoutTitle(),
            'jovepay_coins' => $this->getCheckoutCoinIcons(),
        ));

        return $this->context->smarty->fetch(
            $this->local_path . 'views/templates/hook/payment_option.tpl'
        );
    }

    /**
     * HTML shown under the selected payment option (PS 1.7+).
     * Includes the logo|title|coins label (moved into the radio label by front.js)
     * plus an optional merchant description.
     *
     * @return string
     */
    protected function renderPaymentOptionInfos()
    {
        $desc = Configuration::get('JOVEPAY_DESC');
        if (!is_string($desc)) {
            $desc = '';
        }

        $this->context->smarty->assign(array(
            'jovepay_payment_label' => $this->renderPaymentOptionLabel(),
            'jovepay_desc' => trim($desc),
        ));

        return $this->context->smarty->fetch(
            $this->local_path . 'views/templates/hook/payment_infos.tpl'
        );
    }

    /**
     * This method is used to render the payment button,
     * Take care if the button should be displayed or not.
     */
    public function hookPayment($params)
    {
        if (!$this->active || !$this->checkCurrency($params['cart'])) {
            return;
        }

        $this->smarty->assign(array(
            'module_dir' => $this->_path,
            'jovepay_payment_label' => $this->renderPaymentOptionLabel(),
            'jovepay_title' => $this->getCheckoutTitle(),
        ));

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    /**
     * This hook is used to display the order confirmation page.
     */
    public function hookPaymentReturn($params)
    {
        if ($this->active == false) {
            return;
        }

        $order = $params['objOrder'];

        if ($order->getCurrentOrderState()->id != Configuration::get('PS_OS_ERROR')) {
            $this->smarty->assign('status', 'ok');
        }

        $this->smarty->assign(array(
            'id_order' => $order->id,
            'reference' => $order->reference,
            'params' => $params,
            'total' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
        ));

        return $this->display(__FILE__, 'views/templates/hook/confirmation.tpl');
    }

    /**
     * Return payment options available for PS 1.7+
     *
     * @param array Hook parameters
     *
     * @return array|null
     */
    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }
        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        // CTA text is escaped by the core theme; rich label HTML is injected by front.js.
        $option = new PaymentOption();
        $option
            ->setModuleName($this->name)
            ->setCallToActionText($this->getCheckoutTitle())
            ->setAction($this->context->link->getModuleLink($this->name, 'validation', array(), true))
            ->setAdditionalInformation($this->renderPaymentOptionInfos());

        return array($option);
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);
        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }
}
