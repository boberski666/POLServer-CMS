   <table class="table table-striped table-bordered table-hover">
      <thead>
         <tr>
            <th colspan="1">Create new page</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td><a href = "/admin/page/new/">New page</a></td>
         </tr>
      </tbody>
   </table>
   
<table class="table table-striped table-bordered table-hover">
   <thead>
      <tr>
         <th colspan="4">Pages</th>
      </tr>
   </thead>
   <tbody>
      {foreach from=$_pages_ key=k item=pageItem}
      <tr>
         <td>{$pageItem->name}</td>
         <td>{$pageItem->title}</td>
         <td><a href = "/admin/page/edit/id/{$pageItem->id}">Edit</a></td>
         <td>{if $pageItem->canDelete == 1}<a href = "/admin/page/save/id/{$pageItem->id}">Delete</a>{/if}</td>
      <tr>
         {/foreach}
   </tbody>
</table>