{*
 * JOVEpay payment button for PrestaShop 1.6 checkout.
 *}
<div class="row">
	<div class="col-xs-12 col-md-6">
		<p class="payment_module" id="Jovepay_payment_button">
			<a href="{$link->getModuleLink('Jovepay', 'validation', array(), true)|escape:'htmlall':'UTF-8'}" title="{$jovepay_title|escape:'html':'UTF-8'}">
				{$jovepay_payment_label nofilter}
			</a>
		</p>
	</div>
</div>
