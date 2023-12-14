# Rechnify / Invoicify
simplify sending invoices
--------
Created as an way to ease sending invoices via e-mail to nonprofit clubs for small fees. its in german should be easy to cutomize or modify.

Just html, css, js, php, no database, no dependencies.

Change recipient email in `send.php`.
Cutomize `was.json` (items to add to the invoice) and `vorlage.json` (email content, impressum link).

Basic password protection
set `pw_protect` in `send.php` to true and add the `pw_hash_bcrypt` (create a file with the code below and use /pwhash.php?pw=yourpw to generate it).

`pwhash.php`
```
<?php
  echo password_hash($_GET['pw'], PASSWORD_BCRYPT);
?>
```

Feel free to file an issue or a PR to improve this. It's not supposed to be fancy, its supposed to be easy :)

[LICENSE](https://github.com/ueen/Rechnify/blob/main/LICENSE)
