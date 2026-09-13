{*
 * Shared failure page body.
 *}
<section class="jpps-result jpps-result--failure">
	<h1 class="jpps-result__title">
		{l s='Sorry, your payment could not be completed' mod='Jovepay'}
	</h1>
	<p class="jpps-result__text">
		{l s='The payment was cancelled or failed. No charge was completed. You can return to your cart and try again.' mod='Jovepay'}
	</p>
	<div class="jpps-result__actions">
		<a class="btn btn-primary" href="{$jovepay_cart_url|escape:'html':'UTF-8'}">
			{l s='Return to cart' mod='Jovepay'}
		</a>
		<a class="btn btn-secondary" href="{$jovepay_contact_url|escape:'html':'UTF-8'}">
			{l s='Contact support' mod='Jovepay'}
		</a>
	</div>
</section>
