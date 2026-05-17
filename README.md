<div align="center">
  <img src="favicon.svg" width="72" height="72" alt="Rechnify">

  # Rechnify

  **Lightweight self-hosted invoice tool — pure HTML, CSS, JS and PHP.**  
  No build step. No database. No dependencies.

  [![Release](https://img.shields.io/github/v/release/ueen/Rechnify)](https://github.com/ueen/Rechnify/releases/latest)
  [![License](https://img.shields.io/github/license/ueen/Rechnify)](LICENSE)
  [![Demo](https://img.shields.io/badge/demo-live-brightgreen)](https://ueen.github.io/Rechnify/)
</div>

---

**[→ Live demo](https://ueen.github.io/Rechnify/)**

Built for sending small invoices to nonprofits and clubs. Fill in who, what and when — Rechnify generates a clean PDF. Optionally send it straight by e-mail.

---

## Install

Host the files from the [latest release](https://github.com/ueen/Rechnify/releases/latest) on any PHP-capable server:

```
rechnify.html
vorlage.json
send.php
favicon.svg
```

Open `rechnify.html` in a browser. That's it.

---

## Configure — `vorlage.json`

All global defaults live here. The app reads this file on every load; user overrides are saved in `localStorage`.

### Key fields

| Field | Default | Description |
|---|---|---|
| `letter` | (long German text) | Opening paragraph printed in the PDF — supports `[iban text \| cash text]` conditionals |
| `gruss` | `Mit freundlichen Grüßen` | Closing greeting |
| `currency` | `€` | Displayed next to amounts |
| `digitalsign` | (long text) | Small italic footer line; hide with `""` |
| `impressum` | `""` | Clickable link in the web footer and PDF footer |
| `pw_protect` | `false` | Enable password gate (requires `$password` in `send.php`) |
| `enable_email` | `false` | Enable e-mail sending feature |
| `items` | `{}` | Preset service names and prices |
| `recipients` | `[]` | Pre-loaded recipients (merged with browser-saved ones) |

### Conditional text in the letter

The `letter` field supports `[iban text | cash text]` conditionals. The app picks the left side for bank transfer and the right side for cash, depending on which payment mode is selected when the PDF is generated.

Example:

```
…mit Bitte zur zeitnahen [Überweisung an die unten angegebende IBAN | Auszahlung in bar].
```

Generates as:
- **IBAN:** `…mit Bitte zur zeitnahen Überweisung an die unten angegebende IBAN.`
- **Cash:** `…mit Bitte zur zeitnahen Auszahlung in bar.`

You can use as many `[…|…]` blocks as you like in one letter. The raw syntax is visible and editable in the settings modal — the substitution only happens when the PDF is generated.

---

## E-mail sending

E-mail is **off by default**. To enable:

1. Set `"enable_email": true` in `vorlage.json`
2. Configure `send.php`

### `send.php` — minimal config

```php
$password   = '';              // Set if pw_protect is true
$from_email = 'you@yourdomain.com';  // From address; leave blank for noreply@host
```

When `enable_email` is true and the recipient has an e-mail address:
- The generate button switches to **Preview** — opens the PDF in a new browser tab
- A **Send by e-mail** button appears below it; clicking it sends the PDF via PHP's `mail()`
- Your own e-mail (if entered) is added as **CC**

### SMTP (optional)

`send.php` uses PHP's built-in `mail()` by default, which works on any server with `sendmail` configured. For SMTP, install [PHPMailer](https://github.com/PHPMailer/PHPMailer) and follow the commented block at the top of `send.php`:

```bash
composer require phpmailer/phpmailer
```

---

## Password protection

Set `"pw_protect": true` in `vorlage.json` and set `$password` in `send.php`.

The password can be passed in the URL to skip the prompt:

```
rechnify.html?pw=yourpassword
```

*Consider hosting behind a login or VPN when not using a password.*

---

## Development

No build step. Edit `rechnify.html` directly and serve with any PHP server:

```bash
php -S localhost:8080 -t /tmp/rechnify
```

---

Feel free to open an issue or PR. It's not supposed to be fancy — it's supposed to be easy.

### [LICENSE](LICENSE)
