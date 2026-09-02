#!/usr/bin/env bash
# Create a staging deploy archive (excludes runtime/cache files that cause permission errors).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
STAMP="$(date +%Y%m%d_%H%M%S)"
OUT_DIR="$ROOT/writable/backups"
ARCHIVE="$OUT_DIR/shivalikrasayan_deploy_${STAMP}.zip"

mkdir -p "$OUT_DIR"

cd "$ROOT"

# Remove stale session/cache files so they are not needed in the archive.
find writable/session -type f ! -name 'index.html' -delete 2>/dev/null || true
find writable/cache -type f ! -name 'index.html' -delete 2>/dev/null || true
find writable/debugbar -type f ! -name 'index.html' -delete 2>/dev/null || true

zip -r "$ARCHIVE" . \
  -x '*.git*' \
  -x 'writable/session/*' \
  -x 'writable/cache/*' \
  -x 'writable/logs/*' \
  -x 'writable/debugbar/*' \
  -x 'writable/backups/*.zip' \
  -x 'writable/backups/*.sql' \
  -x 'writable/backups/*.sql.gz' \
  -x '.env' \
  -x 'node_modules/*' \
  -x 'vendor/codeigniter4/framework/writable/*'

echo "Created: $ARCHIVE"
ls -lh "$ARCHIVE"
