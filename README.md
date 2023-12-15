# Rechnify / Invoicify
simplify sending invoices
--------
Created as an way to ease sending invoices via e-mail to nonprofit clubs for small fees. its in german and easy to cutomize or modify.

#### Just html, css, js, php, no database, no dependencies.

## Install
Just host the files from the latest [release](https://github.com/ueen/Rechnify/releases/latest).

## Customize
- #### Change recipient email in `send.php`.
  Can also be set to `false` then the invoice text will be displayed instead of send.

- #### Cutomize `was.json` (items to add to the invoice) and `vorlage.json` (email content, impressum link).

### Basic password protection (optional, defaults to false)
set `pw_protect` in `vorlage.json` to true and add the `$password` in `send.php`.

*Consider hosting internally or within a login area when not using a password to prevent spam.*

The password can also be added to the URL like this `../rechnify.html?pw=yourpassword`.

### GDPR/DSGVO ready
Only md5-hashes of the name combined with three digits of the iban are stored on server to count the invoice number, everything else is stricly and securely stored locally in browser cookies.


#### Feel free to file an issue or a PR to improve this. It's not supposed to be fancy, its supposed to be easy :)

### [LICENSE](https://github.com/ueen/Rechnify/blob/main/LICENSE)
