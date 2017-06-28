<form method="POST" action="/admin/login/">
	<div align="center">
		{if isset($_message_)}
			<p>{$_message_}</p>
		{/if}
		Login: <input type="text" name="username" size="15" /><br /><br />
		Hasło: <input type="password" name="password" size="15" /><br />

		<p><input type="submit" value="Zaloguj" /></p>
	</div>
</form>