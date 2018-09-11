<?php
$command = "grep -ri 'string' ./*";
$output = shell_exec($command);
echo "<pre>";
echo "$output";
echo "Grep job over.";
?>
