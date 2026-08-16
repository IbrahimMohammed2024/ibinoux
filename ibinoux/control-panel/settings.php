<?php
// Ibinoux Settings Editor - بديل بسيط لـ Regedit
// بيقرا/يعدّل ملف إعدادات مركزي JSON بدل ما يلعب في ملفات النظام مباشرة
// ده أأمن بكتير من إنه يعدل في /etc مباشرة من واجهة ويب

$settingsFile = '/etc/ibinoux/settings.json';

if (!file_exists($settingsFile)) {
    @mkdir('/etc/ibinoux', 0755, true);
    file_put_contents($settingsFile, json_encode([
        "system.hostname" => "Ibinoux",
        "system.language" => "ar",
        "network.remote_desktop_enabled" => true,
        "network.ssh_enabled" => true,
        "security.auto_scan_daily" => true,
        "security.firewall_enabled" => true,
        "ui.theme" => "dark",
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$settings = json_decode(file_get_contents($settingsFile), true) ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['keys'] ?? [] as $i => $key) {
        $val = $_POST['values'][$i] ?? '';
        if ($val === 'true') $val = true;
        elseif ($val === 'false') $val = false;
        $settings[$key] = $val;
    }
    file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $saved = true;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Settings Editor - Ibinoux</title>
<style>
  body { font-family: Tahoma, sans-serif; background:#1e1e2e; color:#eee; padding:2rem; }
  a { color:#7dd3fc; }
  table { width:100%; border-collapse:collapse; }
  td, th { padding:.6rem; border-bottom:1px solid #3a3a4d; text-align:right; }
  input { background:#2a2a3d; border:1px solid #444; color:#eee; padding:.4rem; border-radius:4px; width:100%; }
  button { background:#4ade80; border:none; padding:.6rem 1.2rem; border-radius:6px; cursor:pointer; margin-top:1rem; }
  .ok { color:#4ade80; }
</style>
</head>
<body>
  <a href="/ibinoux/index.php">&larr; رجوع للوحة التحكم</a>
  <h1>محرر إعدادات النظام (بديل Regedit)</h1>
  <?php if (!empty($saved)): ?><p class="ok">تم الحفظ بنجاح.</p><?php endif; ?>
  <form method="post">
    <table>
      <tr><th>المفتاح (Key)</th><th>القيمة (Value)</th></tr>
      <?php foreach ($settings as $key => $val): ?>
      <tr>
        <td>
          <input type="hidden" name="keys[]" value="<?= htmlspecialchars($key) ?>">
          <?= htmlspecialchars($key) ?>
        </td>
        <td><input name="values[]" value="<?= htmlspecialchars(is_bool($val) ? ($val ? 'true' : 'false') : $val) ?>"></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <button type="submit">حفظ الإعدادات</button>
  </form>
</body>
</html>
