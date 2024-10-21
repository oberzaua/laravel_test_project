<?php
function fact($n) {
  if ($n == 0) return 1;
  $tmp = $n * fact($n-1);
  return $tmp;
}
echo (fact(3));
// 3 * 2 * 1 = 6
// ⇩ fact(3) -- ⇧ 3 * 2 = 6
// ⇩ fact(2) -- ⇧ 2 * 1 = 2
// ⇩ fact(1) -- ⇧ 1 * 1 = 1
// ⇩ fact(0) -- ⇧ 1
// Zuerst von oben nach unten, da fact immer neu aufgerufen wird. Dann von unten nach oben mit den return Werten.
