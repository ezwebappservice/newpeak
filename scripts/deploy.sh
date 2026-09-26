#!/usr/bin/env bash
# Sync this checkout to the Hostinger document root.
# Requires DEPLOY_HOST, DEPLOY_PORT, DEPLOY_USER, and DEPLOY_PATH.
# SSH auth comes from the agent (GitHub Actions) or the default key.
set -euo pipefail

: "${DEPLOY_HOST:?DEPLOY_HOST is required}"
: "${DEPLOY_PORT:?DEPLOY_PORT is required}"
: "${DEPLOY_USER:?DEPLOY_USER is required}"
: "${DEPLOY_PATH:?DEPLOY_PATH is required}"

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

SSH_OPTS=(-p "$DEPLOY_PORT" -o StrictHostKeyChecking=yes)
RSYNC_RSH="ssh -p ${DEPLOY_PORT} -o StrictHostKeyChecking=yes"
DEST="${DEPLOY_USER}@${DEPLOY_HOST}"

ssh "${SSH_OPTS[@]}" "$DEST" "test -d $(printf '%q' "$DEPLOY_PATH")"

# Keep production secrets, the server git checkout, and generated or uploaded files.
rsync -az --delete \
  -e "$RSYNC_RSH" \
  --exclude '.env' \
  --exclude '.git/' \
  --exclude '.github/' \
  --exclude 'app_old/' \
  --exclude 'public_old/' \
  --exclude 'default.php' \
  --exclude 'writable/cache/*' \
  --exclude 'writable/logs/*' \
  --exclude 'writable/session/*' \
  --exclude 'writable/debugbar/*' \
  --exclude 'writable/uploads/*' \
  --exclude 'writable/investor_documents/*' \
  --exclude 'writable/backups/*' \
  --exclude 'public/uploads/*' \
  --exclude 'build/' \
  --exclude '.phpunit.cache/' \
  ./ "${DEST}:${DEPLOY_PATH}/"

# Update tracked media without removing files that exist only on the server.
rsync -az \
  -e "$RSYNC_RSH" \
  public/uploads/ "${DEST}:${DEPLOY_PATH}/public/uploads/"

ssh "${SSH_OPTS[@]}" "$DEST" "cd $(printf '%q' "$DEPLOY_PATH") && mkdir -p writable/cache writable/logs writable/session writable/debugbar writable/uploads writable/backups writable/investor_documents public/uploads && chmod -R u+rwX writable public/uploads && php spark cache:clear"
