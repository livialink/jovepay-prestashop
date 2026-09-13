# JOVEpay for PrestaShop

JOVEpay is a crypto payment gateway for PrestaShop. Accept Bitcoin, Ethereum, stablecoins, and 100+ other cryptocurrencies at checkout, with settlement to your merchant wallet via [JOVEpay](https://www.jovepay.com).

Customers pay on JOVEpay’s hosted checkout widget (light or dark theme). Your store receives order status updates through secure Instant Payment Notifications (IPN).

![JOVEpay logo](https://res.cloudinary.com/gysvswrq/image/upload/v1789253020/jovepay-240x240.png)

## Requirements

- PrestaShop **1.6** or higher (PrestaShop **8.x** recommended)
- PHP with the **cURL** extension enabled
- An open and **activated** [JOVEpay merchant account](https://app.jovepay.com/). The module cannot process payments until the account is activated.
- **API Key** and **IPN Secret** from the JOVEpay dashboard

## Features

- Accept 100+ cryptocurrencies at PrestaShop checkout
- Redirect customers to JOVEpay’s hosted payment page (light or dark theme)
- Checkout payment option with JOVEpay logo, configurable title, and overlapping coin icons
- Automatic order status updates via HMAC-signed IPN/webhooks
- Testnet mode for safe end-to-end testing
- Configurable checkout title, description, and invoice prefix
- Compatible with PrestaShop 1.6 (`payment` hook) and 1.7+ (`paymentOptions` hook)

## Demo

Try the live demo store: [prestashop.jovepay.com](https://prestashop.jovepay.com/). Sign in to the [JOVEpay dashboard](https://app.jovepay.com/) to create API credentials for your own store.

## Installation

2. Copy your **API Key** from [Payment Settings → API](https://app.jovepay.com/en/payments-settings#api).
3. Copy your **IPN Secret** from [Payment Settings → IPN / Webhooks](https://app.jovepay.com/en/payments-settings#ipn).
1. Zip the `Jovepay` module folder (the folder name must remain `Jovepay`).
5. Fill in the settings:

   | Setting | Description |
   | --- | --- |
   | **Live mode** | Enable the module for live checkout. |
   | **Mainnet / Testnet mode** | Use Testnet for safe testing without real funds. |
   | **Light / Dark theme** | Theme for the JOVEpay hosted payment widget. |
   | **Title** | Label shown next to the logo on the checkout payment option (defaults to “JOVEpay”). |
   | **Description** | Optional text shown when the payment method is selected (PrestaShop 1.7+). |
   | **IPN Secret** | Secret used to verify signed IPN callbacks. |
   | **API Key** | Merchant API key from the JOVEpay dashboard. |
   | **Invoice Prefix** | Optional prefix for invoice / order references when the same JOVEpay account serves multiple stores. |

6. Click **Save**.
7. In the JOVEpay dashboard, configure your IPN / webhook URL to:

   ```text
   https://YOUR-SHOP-DOMAIN/module/Jovepay/ipn
   ```

8. Place a test order to confirm checkout redirect and order status updates.

Full guide: [JOVEpay PrestaShop documentation](https://www.jovepay.com/docs/plugins/prestashop).

## How payment works

1. The customer selects **JOVEpay** (or your configured title) at checkout. The payment option shows the JOVEpay logo, title, and stacked coin icons.
2. PrestaShop redirects them to the JOVEpay hosted payment widget.
3. The customer pays with their preferred cryptocurrency.
4. JOVEpay sends a signed IPN to `module/Jovepay/ipn`. The module verifies the HMAC signature and updates the order.
5. After payment, the customer is returned to your shop via the success or cancel URLs.

## Popular coins

- Bitcoin (BTC)
- Ethereum (ETH)
- BNB Smart Chain (BEP20)
- Litecoin (LTC)
- Bitcoin Cash (BCH)
- Dogecoin (DOGE)
- Solana (SOL)
- and more

### Stablecoins

- Tether (USDT)
- USD Coin (USDC)
- DAI
- TrueUSD (TUSD)
- PayPal USD (PYUSD)
- Global Dollar (USDG)
- EURC

Coin availability depends on your JOVEpay account and network settings. For coin requests or support, contact [info@jovepay.com](mailto:info@jovepay.com).

## Frequently asked questions

### Do I need a JOVEpay account?

Yes. You need an activated merchant account plus API Key and IPN Secret from [app.jovepay.com](https://app.jovepay.com/).

### Can I test without real funds?

Yes. Enable **Testnet** in the module settings and use JOVEpay’s test environment.

### Which PrestaShop versions are supported?

The module declares compatibility from PrestaShop **1.6** upward and is tested for **PrestaShop 8.x**. PHP **8.1+** is recommended for current PrestaShop releases.

### What PHP extension is required?

**cURL** must be enabled. Installation fails with an error if it is missing.

## Release notes

### Version 1.0.0 (Initial release)

- Initial public release of the JOVEpay crypto payment gateway for PrestaShop
- Hosted payment widget with light and dark themes
- Checkout payment option with logo, title, and overlapping coin stack
- HMAC-signed Instant Payment Notifications (IPN)
- Live / testnet modes, configurable title, description, and invoice prefix
- Support for PrestaShop 1.6 payment hook and 1.7+ payment options API

## Support

- Email: [dev@jovepay.com](mailto:dev@jovepay.com)
- Website: [https://www.jovepay.com](https://www.jovepay.com)
- Docs: [https://www.jovepay.com/docs/plugins/prestashop](https://www.jovepay.com/docs/plugins/prestashop)

## License

Academic Free License (AFL 3.0), consistent with PrestaShop module conventions.
