<form action="/admin/page/save/" method="post">
    <input name="title" style = "width: 100%;" value = "" /><br /><br />
    <textarea name="editor_content"></textarea><br />
    <script>
        CKEDITOR.replace('editor_content');
        CKEDITOR.config.allowedContent = true;
    </script>
    <input type="hidden" name="type" value="new"/>
    <input type="submit" name="submit" value="Save" class="btn btn-default"/>
</form>