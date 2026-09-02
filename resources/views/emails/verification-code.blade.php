<!DOCTYPE html>
<html lang="az">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Təsdiq kodu</title>
</head>
<body style="margin:0; padding:0; background:#060806; font-family:Segoe UI, Helvetica, Arial, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#060806; padding:40px 16px;">
  <tr>
    <td align="center">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:480px; background:#0b0f0a; border:1px solid #263620; border-radius:16px; overflow:hidden;">

        <tr>
          <td style="height:6px; background:linear-gradient(120deg,#c6ff1a,#7fd400); background-color:#c6ff1a; line-height:6px; font-size:6px;">&nbsp;</td>
        </tr>

        <tr>
          <td style="padding:36px 36px 0 36px; text-align:center;">
            <div style="font-size:22px; font-weight:800; color:#ffffff; letter-spacing:0.5px;">
              Dark<span style="color:#c6ff1a;">Frame</span>.az
            </div>
          </td>
        </tr>

        <tr>
          <td style="padding:28px 36px 8px 36px; text-align:center;">
            <div style="font-size:19px; font-weight:700; color:#ffffff;">Hesabınızı təsdiqləyin</div>
            <p style="margin:12px 0 0 0; font-size:14px; line-height:1.6; color:#9aa89a;">
              Salam{{ $user->full_name ? ', ' . $user->full_name : '' }}! DarkFrame.az-da qeydiyyatı tamamlamaq üçün aşağıdakı kodu daxil edin.
            </p>
          </td>
        </tr>

        <tr>
          <td style="padding:20px 36px 4px 36px; text-align:center;">
            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto;">
              <tr>
                <td style="background:#11170f; border:1px solid #2f4527; border-radius:12px; padding:18px 28px;">
                  <span style="font-size:36px; font-weight:800; letter-spacing:10px; color:#c6ff1a; font-family:'Courier New', monospace;">
                    {{ $code }}
                  </span>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td style="padding:16px 36px 0 36px; text-align:center;">
            <p style="margin:0; font-size:13px; color:#6b7a68;">Kod 15 dəqiqə ərzində etibarlıdır.</p>
          </td>
        </tr>

        <tr>
          <td style="padding:28px 36px 32px 36px; text-align:center;">
            <p style="margin:0; font-size:12px; line-height:1.6; color:#4d5c4a;">
              Bu qeydiyyatı siz başlatmamısınızsa, bu e-poçtu nəzərə almayın.<br>
              Suallarınız üçün: <a href="mailto:support@darkframe.az" style="color:#c6ff1a; text-decoration:none;">support@darkframe.az</a>
            </p>
          </td>
        </tr>

        <tr>
          <td style="padding:18px 36px; background:#060806; border-top:1px solid #263620; text-align:center;">
            <p style="margin:0; font-size:11px; color:#4d5c4a;">&copy; {{ date('Y') }} DarkFrame.az &mdash; bütün hüquqlar qorunur.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
