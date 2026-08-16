<?php
$action = $_POST['action'] ?? '';
$msg = '';

if ($action === 'scan') {
    $msg = shell_exec("sudo /usr/bin/clamscan -r --quiet /home 2>&1");
} elseif ($action === 'update') {
    $msg = shell_exec("sudo /usr/bin/freshclam 2>&1");
}

$log = @file_get_contents('/var/log/ibinoux-defender.log');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Defender - Ibinoux</title>
<style>
  body { font-family: Tahoma, sans-serif; background:#1e1e2e; color:#eee; padding:2rem; }
  a { color:#7dd3fc; }
  pre { background:#2a2a3d; padding:1rem; border-radius:8px; white-space:pre-wrap; max-height:300px; overflow:auto; }
  button { background:#4ade80; border:none; padding:.6rem 1.2rem; border-radius:6px; cursor:pointer; margin-left:.5rem; }
</style>
</head>
<body>
  <a href="/ibinoux/index.php">&larr; رجوع للوحة التحكم</a>
  <h1>إدارة Defender (ClamAV)</h1>
  <form method="post">
    <button name="action" value="scan">فحص الآن</button>
    <button name="action" value="update">تحديث قاعدة البيانات</button>
  </form>
  <?php if ($msg): ?><h3>النتيجة</h3><pre><?= htmlspecialchars($msg) ?></pre><?php endif; ?>
  <h3>آخر سجل فحص دوري</h3>
  <pre><?= $log ? htmlspecialchars($log) : 'لا يوجد سجل بعد.' ?></pre>
</body>
</html>
