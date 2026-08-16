# Ibinoux OS

توزيعة Linux مخصصة (مبنية على Debian) بالمواصفات دي:
- دعم 32-bit و64-bit (multiarch)
- تشغيل برامج Windows جنب برامج Linux (Wine)
- Firewall افتراضي (nftables/ufw)
- Defender مدمج (ClamAV) + سكريبت تثبيت اختياري لـ Kaspersky Free
- SSH Server + Remote Desktop (xrdp/VNC)
- Terminal/Shell مخصص باسم Ibinoux
- Control Panel أساسي (واجهة ويب محلية)
- دعم واسع للـ drivers عبر kernel حديث + firmware-linux

## المتطلبات لبناء الـ ISO (على جهازك إنت، مش هنا)
هذا مشروع Source فقط. بناء ISO فعلي محتاج:
- جهاز Linux (Debian/Ubuntu) أو VM
- مساحة فارغة: 20 GB على الأقل
- رام: 4 GB على الأقل
- اتصال إنترنت (لتنزيل الحزم وقت البناء)
- وقت: من 30 دقيقة لساعتين حسب سرعة النت والجهاز

## خطوات البناء
```bash
sudo apt update
sudo apt install -y live-build git
cd ibinoux
sudo ./scripts/build.sh
```

الناتج هيكون ملف `ibinoux-*.iso` في مجلد المشروع، جاهز تحرقه على فلاشة (بـ balenaEtcher أو dd) أو تشغله في VirtualBox/VMware.

## هيكل المشروع
```
ibinoux/
├── config/          # إعدادات live-build (package lists, hooks, sudoers)
├── scripts/         # سكريبت البناء + سكريبتات مساعدة (تثبيت Kaspersky إلخ)
├── branding/        # الشعار، اسم النظام، splash screen
├── control-panel/   # واجهة الويب لإدارة النظام (index/firewall/defender/settings)
├── docs/            # توثيق إضافي
├── LICENSE          # رخصة MIT لكود Ibinoux نفسه
└── NOTICE.md        # رخص كل المكونات المستخدمة (Debian, Wine, ClamAV...)
```

## لوحة التحكم (Control Panel)
بعد تشغيل النظام، افتح المتصفح على `http://localhost/ibinoux` وهتلاقي:
- **index.php** — نظرة عامة على حالة كل الخدمات
- **firewall.php** — تفعيل/تعطيل الجدار الناري ومشاهدة القواعد
- **defender.php** — فحص فوري وتحديث قاعدة بيانات ClamAV
- **settings.php** — محرر إعدادات عام (بديل مبسّط لـ Regedit)

⚠️ **تنبيه أمان مهم:** النسخة دي أولية وبدون نظام تسجيل دخول (authentication)
على لوحة التحكم. **لازم تضيف auth حقيقي** (زي HTTP Basic Auth أو نظام
مستخدمين كامل) قبل ما تستخدم النظام ده على أي جهاز متصل بشبكة أو إنترنت،
لأن أي حد يوصل للمتصفح هيقدر يتحكم في الفايروول وتشغيل فحوصات.

## الخطوات الناقصة لو عايز تطوره أكتر
- إضافة تسجيل دخول (login) للـ Control Panel
- تصميم شعار وخلفية حقيقيين (مكانهم في `branding/`)
- اختبار الـ ISO على جهاز حقيقي/VM والتأكد من الدرايفرز
- مراجعة قانونية لاستخدام اسم "Ibinoux" (تأكد إنه مش متعارض مع علامة تجارية موجودة)
