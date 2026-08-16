<?php
// إدارة الـ Firewall عبر sudoers محدود (لازم يتظبط sudoers قبل الاستخدام الفعلي)
$action = $_POST['action'] ?? '';
$msg = '';

if ($action === 'enable') {
    $msg = shell_exec("sudo /usr/sbin/ufw --force enable 2>&1");
} elseif ($action === 'disable') {
    $msg = shell_exec("sudo /usr/sbin/ufw disable 2>&1");
}

$rules = shell_exec("sudo /usr/sbin/ufw status numbered 2>&1");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Firewall - Ibinoux</title>
<style>
  body { font-family: Tahoma, sans-serif; background:#1e1e2e; color:#eee; padding:2rem; }
  a { color:#7dd3fc; }
  pre { background:#2a2a3d; padding:1rem; border-radius:8px; white-space:pre-wrap; }
  button { background:#4ade80; border:none; padding:.6rem 1.2rem; border-radius:6px; cursor:pointer; margin-left:.5rem; }
  button.danger { background:#f87171; }
</style>
</head>
<body>
  <a href="/ibinoux/index.php">&larr; رجوع للوحة التحكم</a>
  <h1>إدارة Firewall</h1>
  <?php if ($msg): ?><pre><?= htmlspecialchars($msg) ?></pre><?php endif; ?>
  <form method="post">
    <button name="action" value="enable">تفعيل</button>
    <button name="action" value="disable" class="danger">تعطيل</button>
  </form>
  <h3>القواعد الحالية</h3>
  <pre><?= htmlspecialchars($rules) ?></pre>
</body>
</html>
