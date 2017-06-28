{include file="tpl/site/header.tpl"}

{include file=$ComponentTpl}

{if isset($debug) && $debug == true}
	{include file='../sys/debug.tpl'}
{/if}


{include file="tpl/site/footer.tpl"}