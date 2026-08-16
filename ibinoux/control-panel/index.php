<?php
// Ibinoux Control Panel - لوحة تحكم أساسية
// ملحوظة أمان: الصفحة دي بتشغل أوامر نظام بصلاحيات محدودة عبر sudoers مخصص.
// لازم تتشغل خلف auth حقيقي قبل أي استخدام فعلي (مش موجود في هذا الإصدار الأولي).

function service_status($name) {
    $out = shell_exec("systemctl is-active " . escapeshellarg($name) . " 2>/dev/null");
    return trim($out) ?: "unknown";
}

$services = [
    "Firewall (ufw)" => "ufw",
    "Defender (ClamAV)" => "clamav-daemon",
    "SSH Server" => "ssh",
    "Remote Desktop (xrdp)" => "xrdp",
    "Web Server" => "apache2",
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Ibinoux Control Panel</title>
<style>
  body { font-family: Tahoma, sans-serif; background:#1e1e2e; color:#eee; margin:0; padding:2rem; }
  h1 { color:#7dd3fc; }
  .card { background:#2a2a3d; border-radius:10px; padding:1.5rem; margin-bottom:1rem; }
  .status { display:flex; justify-content:space-between; padding:.5rem 0; border-bottom:1px solid #3a3a4d; }
  .active { color:#4ade80; font-weight:bold; }
  .inactive { color:#f87171; font-weight:bold; }
  .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; }
</style>
</head>
<body>
  <h1>لوحة تحكم Ibinoux</h1>
  <div class="card">
    <h2>حالة الخدمات</h2>
    <?php foreach ($services as $label => $svc): $status = service_status($svc); ?>
      <div class="status">
        <span><?= htmlspecialchars($label) ?></span>
        <span class="<?= $status === 'active' ? 'active' : 'inactive' ?>"><?= htmlspecialchars($status) ?></span>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="grid">
    <a href="firewall.php" style="text-decoration:none;color:inherit">
      <div class="card">
        <h3>🔥 Firewall</h3>
        <p>إدارة قواعد الحماية والمنافذ المفتوحة.</p>
      </div>
    </a>
    <a href="defender.php" style="text-decoration:none;color:inherit">
      <div class="card">
        <h3>🛡️ Defender</h3>
        <p>فحص الملفات وتحديث قاعدة بيانات الفيروسات.</p>
      </div>
    </a>
    <div class="card">
      <h3>🖥️ Remote Access</h3>
      <p>SSH: منفذ 22 &nbsp;|&nbsp; RDP: منفذ 3389</p>
    </div>
    <a href="settings.php" style="text-decoration:none;color:inherit">
      <div class="card">
        <h3>⚙️ System Settings</h3>
        <p>محرر الإعدادات العامة (بديل Regedit).</p>
      </div>
    </a>
  </div>
</body>
</html>
