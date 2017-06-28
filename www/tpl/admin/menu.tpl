<ul id="nav">
	<li><a href="/admin">Start</a></li>
	{foreach from=$_menu_ key=k item=menuItem}
		   <li><a href="/admin/{$menuItem->url}">{$menuItem->name}</a></li>
	{/foreach}
	<li><a href="/admin/logout">Logout</a></li>
</ul>