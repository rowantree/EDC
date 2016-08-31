<?php

function TraceMsg($msg)
{
	error_log( date('[ymd-His]') . ':' .$msg . "\n", 3, "trace.log");
}

?>