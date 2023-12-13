# Rechnify / Invoicify
simplify sending invoices
--------
Created as an way to ease sending invoices via e-mail to nonprofit clubs for small fees. its in german should be easy to cutomize.

Just html, css, js, php, no database, no dependencies.

Cutomize `was.json` (items to add to the invoice) and `vorlage.json` (recipient and email content).

Basic password protection
set `pw` in `vorlage.json` to true and add the hash (create a file with the code below and use pwhash.php?pw=yourw to generate it).

`pwhash.php`
```
<?php
  echo password_hash($_GET['pw']);
?>
```

Feel free to file an issue or a PR to improve this. It's not supposed to be fancy, its supposed to be easy :)
