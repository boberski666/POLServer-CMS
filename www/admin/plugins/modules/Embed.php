<?php

$this->register_function('embed', 'print_embed');

function print_embed($params, &$smarty) {
    include($params['dir']);
	return '';
}