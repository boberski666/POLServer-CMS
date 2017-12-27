<form action="/admin/page/save/" method="post"">
    /page/{$_page_['name']}<br />
    <input name="title" style = "width: 100%;" value = "{$_page_['title']}" /><br /><br />
    <textarea name="editor_content">{$_page_['source']}</textarea><br />
    <input type="hidden" name="id" value="{$_page_['id']}"/>
    <input type="hidden" name="type" value="edit"/>
    <input type="submit" name="submit" value="Save" class="btn btn-default"/>
</form>