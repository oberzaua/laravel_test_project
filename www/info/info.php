<?php
echo '<br>' . 'Die installierte PHP Version ist ' . phpversion();
echo '<br>' . 'Die installierte xdebug Version ist ' . phpversion('xdebug');
echo '<br>' . 'Die installierten Erweiterungen sind: <br>';
print_r(implode(', ', get_loaded_extensions()));
phpinfo();
