<form method="POST" action="/admin/login/">
	<div class="form-group" align="center">
		{if isset($_message_)}
			<p class="help-block">{$_message_}</p>
		{/if}
		<label>Login</label>
        <input type="text" name="username" size="15" class="form-control" />
		<label>Password</label>
        <input type="password" name="password" size="15" class="form-control" />

		<br/><input type="submit" value="Log In" class="btn btn-default"/>
	</div>
</form>