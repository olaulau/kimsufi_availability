<?php

$cmd = 'cd ./scripts/ && ./mail.sh email@gmail.com "subject avec accents éé èèè ààà ççç ôôô òòò ùùù €€€" "body avec accents éé èèè ààà ççç ôôô òòò ùùù €€€"';
exec ( $cmd.' 2>&1' , $output , $return_var );

echo "<pre>$cmd</pre>";
echo "<pre>$return_var</pre>";
echo "<pre>" . var_export($output, true) . "</pre>";
