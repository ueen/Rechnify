<div align="center">
  <img src="favicon.svg" width="72" height="72" alt="Rechnify">

  # Rechnify

  **Self-hosted invoice tool — pure HTML, CSS, JS and PHP.**  
  No build step. No database. No dependencies.

  [![Release](https://img.shields.io/github/v/release/ueen/Rechnify)](https://github.com/ueen/Rechnify/releases/latest)
  [![License](https://img.shields.io/github/license/ueen/Rechnify)](LICENSE)
  [![Demo](https://img.shields.io/badge/demo-live-brightgreen)](https://ueen.github.io/Rechnify/)
</div>

---

**[→ Live demo](https://ueen.github.io/Rechnify/)**

Fill in who, what and when — Rechnify generates a clean PDF. Optionally send it by e-mail.

---

## Install

Drop the files from the [latest release](https://github.com/ueen/Rechnify/releases/latest) on any PHP server and open `rechnify.html`.

---

## Configure — `vorlage.json`

| Field | Description |
|---|---|
| `letter` | Opening paragraph in the PDF — supports `[iban text \| cash text]` conditionals |
| `gruss` | Closing greeting |
| `currency` | Symbol displayed next to amounts |
| `digitalsign` | Small italic footer line; `""` to hide |
| `impressum` | Clickable link in footer and PDF |
| `pw_protect` | Password gate (`true`/`false`) |
| `enable_email` | E-mail sending feature (`true`/`false`) |
| `items` | Preset service names and prices `{"Name": 60}` |
| `recipients` | Pre-loaded recipients, shown at the bottom of the dropdown |

### Letter conditionals

Write `[iban text | cash text]` anywhere in the letter — Rechnify picks the right side based on the payment mode selected at generate time. Editable in Settings.

```
…[Überweisung an die unten angegebende IBAN | Auszahlung in bar].
```

---

## E-mail

Set `"enable_email": true` and configure `send.php`:

```php
$password   = '';                    // required if pw_protect: true
$from_email = 'you@yourdomain.com';  // leave blank for noreply@host
```

For SMTP, install [PHPMailer](https://github.com/PHPMailer/PHPMailer) and follow the commented block in `send.php`.

---

## Password protection

Set `"pw_protect": true` in `vorlage.json` and `$password` in `send.php`. Pass it in the URL to skip the prompt: `rechnify.html?pw=yourpassword`

---

[LICENSE](LICENSE)
