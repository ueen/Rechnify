# Rechnify / Invoicify
simplify sending invoices
--------
Created as an way to ease sending invoices via e-mail to nonprofit clubs for small fees. its in german and easy to cutomize or modify.

#### Just html, css, js, php, no database, no dependencies.

## Install
Just host the files from the latest [release](https://github.com/ueen/Rechnify/releases/latest).

## Customize
### Change recipient email in `send.php`.
Cutomize `was.json` (items to add to the invoice) and `vorlage.json` (email content, impressum link).

### Basic password protection (optional defaults to false)
set `pw_protect` in `vorlage.json` to true and add the `$password` in `send.php`.


#### Feel free to file an issue or a PR to improve this. It's not supposed to be fancy, its supposed to be easy :)

### [LICENSE](https://github.com/ueen/Rechnify/blob/main/LICENSE)
