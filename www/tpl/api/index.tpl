{if isset($_raw_) && $_raw_ == true}
{$_json_|@json_encode}
{else}
{if isset($debug) && $debug == true}
{['data' => $_json_, 'debug' => ['sql' => $sql_log, 'controller' => $controller_log, 'action' => $action_log, 'subdomain' => $subdomain_log]]|@json_encode}
{else}
{['data' => $_json_]|@json_encode}
{/if}
{/if}