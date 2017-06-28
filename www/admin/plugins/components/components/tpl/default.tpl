{include file="tpl/admin/menu.tpl"}

<div style="clear: both;"></div>

<ul id="component">
   <li>
	   <h2>Install component</h2>
	   <hr/>
		<form action="/admin/install/upload" method="post" enctype="multipart/form-data">
			Plik: <input type="file" name="com" size="25" accept=".zip"/>
			<input type="submit" name="submit" value="Upload"/>
		</form>
		<hr/>
   </li>
</ul>

<ul id="component">
   <li>
	   <h2>Admin components</h2>
		{foreach from=$_admin_ key=k item=adminItem}
			<hr/>
		   <div style = "width: 200px; float: left;">{$adminItem->name}</div>
		   <div style = "width: 200px; float: left;">{$adminItem->url}</div>
		   <div style = "width: 200px; float: left;">{$adminItem->version}</div>
		   
		   {if $adminItem->canUninstall == 1}
			<div style = "width: 200px; float: left;"><a href = "/admin/install/remove/type/1/id/{$adminItem->id}">Uninstall</a></div>
		   {/if}
		   
		   <div style="clear: both;"></div>
		   <hr/>
		{/foreach}
   </li>
   <li>
	   <h2>Site components</h2>
		{foreach from=$_site_ key=k item=siteItem}
		   <div style = "width: 200px; float: left;">{$siteItem->name}</div>
		   <div style = "width: 200px; float: left;">{$siteItem->url}</div>
		   <div style = "width: 200px; float: left;">{$siteItem->version}</div>
		   
		   {if $siteItem->canUninstall == 1}
			<div style = "width: 200px; float: left;"><a href = "/admin/install/remove/type/2/id/{$siteItem->id}">Uninstall</a></div>
		   {/if}
		   
		   <div style="clear: both;"></div>
		   <hr/>
		{/foreach}
   </li>
</ul>
