<link rel="stylesheet" href="{$smarty.const.DOMAIN|cat:'/tpl/sys/css/debug.css'}" media="all" type="text/css" />
<div id=debug>
	<div class=ajax_debuger_show>
		<a href = "javascript: tplDebug();">Template debugger</a>
	</div>
	<ul>
		{if !empty($debug_exception)}
			<li style="font-weight:bold;color:red;text-shadow:1px 1px 0 #fff">Houston, we have a problem: {$debug_exception.info}</li>
			<ol style="color:red;text-shadow:1px 1px 0 #fff">
				<li><strong>Message:</strong> {$debug_exception.message}</li>
				<li><strong>File:</strong> {$debug_exception.file}</li>
				<li><strong>Line:</strong> {$debug_exception.line}</li>
			</ol>
		{/if}
		{if $sql_log.totalQueries}
			<li><strong>Time:</strong> {$sql_log.totalTime|default:0} ms</li>
			<li><strong>Queries:</strong> {$sql_log.totalQueries|@count}</li>
			{if $sql_log.totalErrors > 0}<li style="color:red;"><strong>Error count:</strong> {$sql_log.totalErrors}</li>{/if}
		{/if}
		<li><strong>Controllers:</strong>
		{foreach from=$controller_log item=c name=c}
			{$c}{if not $smarty.foreach.c.last},{/if}
		{/foreach}
		</li>
		<li><strong>Actions:</strong>
		{foreach from=$action_log item=a name=a}
			{$a}{if not $smarty.foreach.a.last},{/if}
		{/foreach}
		</li>
		<li><strong>Subdomain:</strong>
			{if !empty($subdomain_log)}{$subdomain_log}{else}none{/if}
		</li>
</ul>
{if $sql_log.totalQueries|@count >0}
	<div class=debug_details>
		{foreach from=$sql_log.totalQueries item=query_item}
			<div class="{if $query_item.result && $query_item.row_count>0}query_ok{/if}{if $query_item.error[2]} query_error{/if}">
				<table width=100% ondblclick="fnSelect(jQuery(this).find('div.mysql').get(0))">
					<tr>
						<td align=left>{geshi lang=mysql}{$query_item.query}{/geshi}</td>
						<td align=right width=60 valign=middle style="font-weight:bold;border-left:#{if $query_item.error[2]}F00{else if $query_item.result && $query_item.row_count>0}0F0{else}D3D3D3{/if} dashed 1px" >{$query_item.time} ms</td>
					</tr>
				</table>

				{if $query_item.file}
					<div class=file_info><div>{$query_item.file|replace:$smarty.const.ADMIN_DIR:''} &rArr; linia {$query_item.line}</div> {geshi lang=php}{$query_item.object}{/geshi}<div class=clear></div></div>
				{/if}

				{if $query_item.error[2]}<div class=sql_error>{$query_item.error[2]}</div>{/if}
			</div>
		{/foreach}
	</div>
{/if}
</div>