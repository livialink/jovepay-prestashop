{*
 * JOVEpay payment success return page (PrestaShop 1.6).
 *}
<section class="jpps-result jpps-result--success">
	<h1 class="jpps-result__title">
		{l s='Thank you, your payment is successful' mod='Jovepay'}
	</h1>
	<p class="jpps-result__text">
		{l s='Your order has been received and payment is being confirmed. You will receive an email confirmation shortly.' mod='Jovepay'}
	</p>
	<div class="jpps-result__actions">
		<a class="btn btn-primary" href="{$jovepay_orders_url|escape:'html':'UTF-8'}">
			{l s='View my orders' mod='Jovepay'}
		</a>
		<a class="btn btn-secondary" href="{$jovepay_shop_url|escape:'html':'UTF-8'}">
			{l s='Continue shopping' mod='Jovepay'}
		</a>
	</div>
</section>
