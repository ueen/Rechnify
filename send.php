<?php
// ── Configuration ────────────────────────────────────────────────────────────
$password   = '';   // Required when pw_protect: true in vorlage.json
$from_email = '';   // From address, e.g. 'invoices@yourdomain.com'
                    // Leave blank to use noreply@<your-host>

// ── SMTP via PHPMailer (optional) ────────────────────────────────────────────
// Install: composer require phpmailer/phpmailer
// Then replace the mail() call below with the PHPMailer block.
//
// require 'vendor/autoload.php';
// use PHPMailer\PHPMailer\PHPMailer;
// $mail = new PHPMailer(true);
// $mail->isSMTP();
// $mail->Host       = 'smtp.example.com';
// $mail->SMTPAuth   = true;
// $mail->Username   = 'you@example.com';
// $mail->Password   = 'secret';
// $mail->SMTPSecure = 'tls';
// $mail->Port       = 587;
// ─────────────────────────────────────────────────────────────────────────────

// ── Password verification ─────────────────────────────────────────────────────
if (isset($_POST['verifypw'])) {
    echo ($_POST['verifypw'] === $password) ? 'true' : 'false';
    exit;
}

// ── Send invoice via e-mail ───────────────────────────────────────────────────
if (isset($_POST['sendmail'])) {
    $to       = filter_var(trim($_POST['to']        ?? ''), FILTER_VALIDATE_EMAIL);
    $fromName = trim($_POST['from_name'] ?? 'Rechnify');
    $subject  = trim($_POST['subject']   ?? 'Rechnung');
    $bodyText = trim($_POST['body']      ?? '');
    $gruss    = trim($_POST['gruss']     ?? '');
    $sender   = trim($_POST['sender']    ?? '');
    $pdfB64   = $_POST['pdf']            ?? '';

    if (!$to || !$pdfB64) { echo 'error'; exit; }

    $pdf = base64_decode(preg_replace('#^data:application/pdf;base64,#', '', $pdfB64));
    if (!$pdf) { echo 'error'; exit; }

    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $fromAddr = $from_email ?: 'noreply@' . $host;
    $boundary = 'rechnify_' . bin2hex(random_bytes(8));

    $plain = '';
    if ($bodyText) $plain .= $bodyText . "\r\n\r\n";
    if ($gruss && $sender) $plain .= $gruss . "\r\n" . $sender . "\r\n";
    if (!$plain) $plain = 'Bitte finden Sie die Rechnung im Anhang.';

    $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $subject) . '.pdf';

    $cc = filter_var(trim($_POST['cc'] ?? ''), FILTER_VALIDATE_EMAIL);
    $headerLines = [
        'MIME-Version: 1.0',
        "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
        'From: =?UTF-8?B?' . base64_encode($fromName) . '?= <' . $fromAddr . '>',
        'X-Mailer: Rechnify',
    ];
    if ($cc) $headerLines[] = 'Cc: ' . $cc;
    $headers = implode("\r\n", $headerLines);

    $message = "--{$boundary}\r\n"
             . "Content-Type: text/plain; charset=UTF-8\r\n"
             . "Content-Transfer-Encoding: quoted-printable\r\n\r\n"
             . quoted_printable_encode($plain) . "\r\n"
             . "--{$boundary}\r\n"
             . "Content-Type: application/pdf; name=\"{$filename}\"\r\n"
             . "Content-Transfer-Encoding: base64\r\n"
             . "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n"
             . chunk_split(base64_encode($pdf)) . "\r\n"
             . "--{$boundary}--";

    $encSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    echo mail($to, $encSubject, $message, $headers) ? 'ok' : 'error';
    exit;
}
