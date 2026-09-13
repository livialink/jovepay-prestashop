{*
 * JOVEpay payment failure / cancel return page (PrestaShop 1.7+).
 *}
{extends file='page.tpl'}

{block name='page_title'}
	{l s='Payment failed' mod='Jovepay'}
{/block}

{block name='page_content'}
	{include file='module:Jovepay/views/templates/front/_partials/failure-content.tpl'}
{/block}
