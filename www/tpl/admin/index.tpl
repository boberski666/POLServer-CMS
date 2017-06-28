{include file="tpl/admin/header.tpl"}
{if isset($ComponentTpl)}
	{include file=$ComponentTpl}
{/if}
{if isset($debug) && $debug == true}
	{include file='../sys/debug.tpl'}
{/if}
{include file="tpl/admin/footer.tpl"}