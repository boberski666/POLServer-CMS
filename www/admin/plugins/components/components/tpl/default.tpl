<form action="/admin/install/upload" method="post" enctype="multipart/form-data">
   <table class="table table-striped table-bordered table-hover">
      <thead>
         <tr>
            <th colspan="2">Install component</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td><input type="file" name="com" size="25" accept=".zip"/></td>
            <td class="text-center"><input type="submit" name="submit" value="Upload" class="btn btn-default"/></td>
         </tr>
      </tbody>
   </table>
</form>
<table class="table table-striped table-bordered table-hover">
   <thead>
      <tr>
         <th colspan="4">Admin components</th>
      </tr>
   </thead>
   <tbody>
      {foreach from=$_admin_ key=k item=adminItem}
      <tr>
         <td>{$adminItem->name}</td>
         <td>{$adminItem->url}</td>
         <td>{$adminItem->version}</td>
         <td>{if $adminItem->canUninstall == 1}<a href = "/admin/install/remove/type/1/id/{$adminItem->id}">Uninstall</a>{/if}</td>
      <tr>
         {/foreach}
   </tbody>
</table>
<table class="table table-striped table-bordered table-hover">
   <thead>
      <tr>
         <th colspan="4">Site components</th>
      </tr>
   </thead>
   <tbody>
      {foreach from=$_site_ key=k item=siteItem}
      <tr>
         <td>{$siteItem->name}</td>
         <td>{$siteItem->url}</td>
         <td>{$siteItem->version}</td>
         <td>{if $siteItem->canUninstall == 1}<a href = "/admin/install/remove/type/2/id/{$siteItem->id}">Uninstall</a>{/if}</td>
      </tr>
      {/foreach}
   </tbody>
</table>