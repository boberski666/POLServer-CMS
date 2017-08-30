<li><a href="/admin"><i class="fa fa-desktop "></i>Start</a></li>
{foreach from=$_menu_ key=k item=menuItem}
   <li><a href="/admin/{$menuItem->url}"><i class="fa fa-gear "></i>{$menuItem->name}</a></li>
{/foreach}
<li><a href="/admin/rawsecure/sql" target="_blank"><i class="fa fa-gear "></i>SQL Admin</a></li>
<li><a href="/admin/logout"><i class="fa fa-key "></i>Logout</a></li>
