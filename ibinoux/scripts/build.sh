#!/bin/bash
# ============================================================
# Ibinoux OS - Build Script
# لازم يتشغل بصلاحيات root على جهاز Debian/Ubuntu حقيقي أو VM
# ============================================================
set -e

if [ "$EUID" -ne 0 ]; then
  echo "لازم تشغل السكريبت ده بـ sudo"
  exit 1
fi

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BUILD_DIR="$PROJECT_ROOT/build"

echo "=== [1/6] تجهيز مجلد البناء ==="
rm -rf "$BUILD_DIR"
mkdir -p "$BUILD_DIR"
cd "$BUILD_DIR"

echo "=== [2/6] تهيئة live-build (Debian Bookworm، دعم amd64 + i386) ==="
lb config \
  --distribution bookworm \
  --architectures amd64,i386 \
  --binary-images iso-hybrid \
  --archive-areas "main contrib non-free non-free-firmware" \
  --debian-installer live \
  --iso-application "Ibinoux OS" \
  --iso-volume "IBINOUX" \
  --iso-publisher "Ibinoux Project"

echo "=== [3/6] نسخ قوائم الحزم ==="
mkdir -p config/package-lists
cp "$PROJECT_ROOT/config/package-lists/"*.list.chroot config/package-lists/

echo "=== [4/6] نسخ الـ hooks (Firewall / ClamAV / Wine / xrdp / Branding) ==="
mkdir -p config/hooks/live
cp "$PROJECT_ROOT/config/hooks/"*.hook.chroot config/hooks/live/
chmod +x config/hooks/live/*.hook.chroot

echo "=== [5/6] نسخ ملفات الـ Branding ==="
mkdir -p config/includes.chroot/usr/share/ibinoux
cp -r "$PROJECT_ROOT/branding/"* config/includes.chroot/usr/share/ibinoux/

mkdir -p config/includes.chroot/usr/local/bin
cp "$PROJECT_ROOT/scripts/install-kaspersky.sh" config/includes.chroot/usr/local/bin/
cp "$PROJECT_ROOT/scripts/ibinoux-shell-welcome.sh" config/includes.chroot/usr/local/bin/
chmod +x config/includes.chroot/usr/local/bin/*.sh

mkdir -p config/includes.chroot/var/www/ibinoux-control-panel
cp -r "$PROJECT_ROOT/control-panel/"* config/includes.chroot/var/www/ibinoux-control-panel/

mkdir -p config/includes.chroot/etc/sudoers.d
cp "$PROJECT_ROOT/config/includes.chroot-extra/etc-sudoers-ibinoux-control-panel" \
   config/includes.chroot/etc/sudoers.d/ibinoux-control-panel
chmod 0440 config/includes.chroot/etc/sudoers.d/ibinoux-control-panel

echo "=== [6/6] بدء بناء الـ ISO (هياخد وقت طويل) ==="
lb build

echo ""
echo "=== تم! ==="
echo "الملف موجود في: $BUILD_DIR/*.iso"
