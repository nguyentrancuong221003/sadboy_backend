<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Chào mừng</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center" style="padding:20px 10px;">
        <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.08);">
          <!-- Header -->
          <tr>
            <td style="padding:24px 32px;background:linear-gradient(90deg,#4f46e5,#06b6d4);color:#fff;">
              <h1 style="margin:0;font-size:20px;font-weight:700;">SADBOY</h1>
            </td>
          </tr>

          <!-- Hero -->
          <tr>
            <td style="padding:28px 32px;text-align:left;">
              <h2 style="margin:0 0 8px 0;font-size:22px;color:#111827;">Chào mừng, {{ $user->name ?? 'bạn' }} 🎉</h2>
              <p style="margin:0 0 18px 0;color:#374151;line-height:1.5;">
                Cảm ơn bạn đã đăng ký tài khoản tại <strong>{{ config('app.name') }}</strong>. Chúng tôi rất vui khi bạn đã tham gia cộng đồng.
              </p>

              <!-- Card -->
              <div style="background:#f8fafc;border-radius:8px;padding:16px;margin:16px 0;">
                <p style="margin:0;color:#374151;font-size:14px;line-height:1.5;">
                  <strong>Tên tài khoản:</strong> {{ $user->name ?? '—' }}<br>
                  <strong>Email:</strong> {{ $user->email ?? '—' }}
                </p>
              </div>

              <!-- CTA -->
              <p style="margin:20px 0 0 0;">
                <a href="{{ config('app.frontend_url') }}" style="display:inline-block;padding:12px 20px;border-radius:6px;text-decoration:none;font-weight:600;background:#4f46e5;color:#fff;">
                  Truy cập vào trang web
                </a>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:20px 32px 28px 32px;font-size:13px;color:#6b7280;background:#fbfdff;">
              <p style="margin:0 0 8px 0;">Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email hoặc liên hệ với chúng tôi.</p>
              <p style="margin:0;">Trân trọng,<br>{{ config('app.name') }}</p>
            </td>
          </tr>

        </table>

        <!-- small footer -->
        <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:12px;">
          <tr>
            <td align="center" style="color:#9ca3af;font-size:12px;">
              © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</body>
</html>
