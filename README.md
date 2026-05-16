<div align="center">
  <img src="favicon.svg" width="72" height="72" alt="Rechnify">

  # Rechnify

  **Lightweight self-hosted invoice tool — pure HTML, CSS, JS and PHP.**  
  No build step. No database. No dependencies.

  [![Release](https://img.shields.io/github/v/release/ueen/Rechnify)](https://github.com/ueen/Rechnify/releases/latest)
  [![License](https://img.shields.io/github/license/ueen/Rechnify)](LICENSE)
</div>

---

Built for sending small invoices to nonprofits and clubs. Fill in who, what and when — Rechnify generates a clean PDF. Optionally send it straight by e-mail.

## Features

- **Preset recipients** — stored in `vorlage.json`, editable in the Settings modal
- **Preset items** — pre-configured services with prices, also manageable in-app
- **Address _or_ e-mail** — physical address and e-mail are both optional, at least one required
- **Decimal amounts** — `50,99` and `50.99` both work; separator follows UI language
- **10 languages** — DE EN FR ES IT PT NL PL SV JA, auto-detected from browser
- **System theme** — follows OS dark/light preference, togglable
- **Optional e-mail sending** — send the PDF directly from the browser via PHP mail / SMTP
- **PDF preview** — opens in a new tab before sending (when e-mail mode is active)
- **Password protection** — optional, set via `vorlage.json` + `send.php`
- **Local-only storage** — all data lives in browser cookies / localStorage; nothing is sent to a server unless you enable e-mail

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

```jsonc
{
  "letter": "Sehr geehrte Damen und Herren…",   // Opening paragraph in the PDF
  "gruss": "Mit freundlichen Grüßen",            // Closing line
  "currency": "€",                               // Currency symbol
  "digitalsign": "--- Digital erstellt ---",     // Footer note (set "" to hide)
  "impressum": "https://example.com/impressum/", // Footer link (set "" to hide)

  "pw_protect": false,   // true → page asks for a password on load (set $password in send.php)
  "enable_email": false, // true → shows "Send by e-mail" button when recipient has an e-mail address

  "items": {
    "Interview": 60,
    "Lesson": 30
  },

  "recipients": [
    { "name": "Beispiel e.V.", "address": "Beispielstraße 1, 12345 Stadt", "email": "info@example.com" }
  ]
}
```

### Key fields

| Field | Default | Description |
|---|---|---|
| `letter` | (long German text) | Opening paragraph printed in the PDF |
| `gruss` | `Mit freundlichen Grüßen` | Closing greeting |
| `currency` | `€` | Displayed next to amounts |
| `digitalsign` | (long text) | Small italic footer line; hide with `""` |
| `impressum` | `""` | Clickable link in the web footer and PDF footer |
| `pw_protect` | `false` | Enable password gate (requires `$password` in `send.php`) |
| `enable_email` | `false` | Enable e-mail sending feature |
| `items` | `{}` | Preset service names and prices |
| `recipients` | `[]` | Pre-loaded recipients (merged with browser-saved ones) |

---

## E-mail sending

E-mail is **off by default**. To enable:

1. Set `"enable_email": true` in `vorlage.json`
2. Configure `send.php`

### `send.php` — minimal config

```php
$password   = '';              // Set if pw_protect is true
$from_email = 'invoices@yourdomain.com';  // From address; leave blank for noreply@host
```

When `enable_email` is true and the recipient has an e-mail address:
- The generate button switches to **Preview** — opens the PDF in a new browser tab
- A **Send by e-mail** button appears below it
- Clicking Send posts the PDF to `send.php` via PHP's `mail()`
- Your own e-mail (if entered) is added as **CC**

### SMTP (optional)

`send.php` uses PHP's built-in `mail()` by default. To use SMTP, install [PHPMailer](https://github.com/PHPMailer/PHPMailer) and follow the commented block at the top of `send.php`:

```bash
composer require phpmailer/phpmailer
```

Then uncomment and fill in the SMTP block in `send.php`.

---

## Password protection

Set `"pw_protect": true` in `vorlage.json` and set `$password` in `send.php`.

The password can be passed in the URL to skip the prompt:

```
rechnify.html?pw=yourpassword
```

*Consider hosting behind a login or VPN when not using a password.*

---

## What's new in v2.0

- `vorlage.json` now controls **all** configuration — letter, recipients, presets, currency, impressum
- `was.json` removed — items now live under `"items"` in `vorlage.json`
- New `enable_email` flag — e-mail sending is off by default, opt-in
- **PDF preview** in new tab before sending (no double invoice-number increment)
- **Decimal commas** — `50,99` works; separator is locale-aware per UI language
- **Browser language auto-detection** and **OS theme auto-detection**
- **Address or e-mail** — both optional, at least one required; red highlight on missing fields
- No toasts — validation uses inline red borders with shake animation
- `send.php` has a clean config section at the top for `$password` and `$from_email`

---

## GDPR / DSGVO

- All personal data (name, address, IBAN, recipients) is stored **only in browser cookies** and `localStorage`
- Invoice counter is stored in a browser cookie (no server-side state)
- Nothing is sent to a server unless you click "Send by e-mail"

---

## Development

No build step. Edit `rechnify.html` directly and serve with any PHP server:

```bash
php -S localhost:8080 -t /tmp/rechnify
```

---

Feel free to open an issue or PR. It's not supposed to be fancy — it's supposed to be easy.

### [LICENSE](LICENSE)
