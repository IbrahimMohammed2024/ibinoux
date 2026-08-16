#!/bin/bash
# ============================================================
# تثبيت Kaspersky Free على Ibinoux (اختياري - بعد تشغيل النظام)
# ملحوظة: Kaspersky برنامج تجاري مملوك للشركة، لازم يتنزل من
# موقعهم الرسمي مباشرة ومش بيتوزع جوه Ibinoux نفسه.
# السكريبت ده بيسهلّك خطوات التنزيل والتثبيت بس.
# ============================================================
set -e

echo "=== تثبيت Kaspersky Free على Ibinoux ==="
echo "هيتم فتح صفحة التحميل الرسمية من موقع Kaspersky..."

if [ "$EUID" -ne 0 ]; then
  echo "شغل السكريبت بـ sudo"
  exit 1
fi

DOWNLOAD_URL="https://www.kaspersky.com/free-antivirus"
echo "افتح الرابط ده وحمّل نسخة Linux من Kaspersky Free:"
echo "$DOWNLOAD_URL"

xdg-open "$DOWNLOAD_URL" 2>/dev/null || echo "افتح الرابط يدويًا من المتصفح."

echo ""
echo "بعد التحميل، رجّع تشغل:"
echo "  sudo dpkg -i kaspersky-free-antivirus_*.deb"
echo "  sudo apt-get install -f"
echo ""
echo "ملحوظة: تقدر تسيب ClamAV شغال جنبه، أو توقفه بـ:"
echo "  sudo systemctl disable --now clamav-daemon clamav-freshclam"
