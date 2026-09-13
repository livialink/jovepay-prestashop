{*
 * Extra checkout content for JOVEpay (PS 1.7+).
 * Label HTML is moved into the payment-option <label> by front.js (CTA text is escaped).
 *}
<div class="jpps-label-source" hidden aria-hidden="true">
	{$jovepay_payment_label nofilter}
</div>
{if isset($jovepay_desc) && $jovepay_desc}
	<section class="js-payment-jovepay-form jpps-payment-infos">
		<p>{$jovepay_desc|escape:'html':'UTF-8'}</p>
	</section>
{/if}
