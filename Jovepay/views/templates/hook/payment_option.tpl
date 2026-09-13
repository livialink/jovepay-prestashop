{*
 * JOVEpay checkout payment option label — logo, title, overlapping coin stack.
 *}
<span class="jpps-payment-method-label">
	<img class="jpps-payment-icons__logo" src="{$jovepay_logo|escape:'html':'UTF-8'}" alt="" />
	<span class="jpps-payment-method-label__text">{$jovepay_title|escape:'html':'UTF-8'}</span>
	{if isset($jovepay_coins) && $jovepay_coins|@count}
		<span class="jpps-payment-icons" aria-hidden="true">
			<span class="jpps-payment-icons__stack">
				{foreach from=$jovepay_coins item=coin}
					<img
						class="jpps-payment-icons__coin"
						src="{$coin.src|escape:'html':'UTF-8'}"
						alt="{$coin.alt|escape:'html':'UTF-8'}"
						style="z-index:{$coin.z_index|intval}"
					/>
				{/foreach}
			</span>
		</span>
	{/if}
</span>
