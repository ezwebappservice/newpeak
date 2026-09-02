#!/usr/bin/env bash
# Push to https://github.com/ezwebappservice/shivalikrasayan
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
GH="${GH:-$HOME/bin/gh}"
SSH_REMOTE="git@github.com:ezwebappservice/shivalikrasayan.git"
HTTPS_REMOTE="https://github.com/ezwebappservice/shivalikrasayan.git"
MODE="${1:-auto}"

cd "$ROOT"

ssh_ok() {
  local out
  out="$(ssh -o BatchMode=yes -o StrictHostKeyChecking=accept-new -T git@github.com 2>&1)" || true
  grep -qi 'successfully authenticated' <<< "$out"
}

ensure_remote() {
  local url="$1"
  if ! git remote get-url origin >/dev/null 2>&1; then
    git remote add origin "$url"
  else
    git remote set-url origin "$url"
  fi
  echo "Remote: $(git remote get-url origin)"
}

push_main() {
  git push -u origin main
  echo ""
  echo "Done: https://github.com/ezwebappservice/shivalikrasayan"
}

show_ssh_help() {
  echo ""
  echo "Option A – SSH (recommended after one-time setup)"
  echo "  1. Login to GitHub as ezwebappservice"
  echo "  2. Open https://github.com/settings/keys → New SSH key"
  echo "  3. Paste this key:"
  echo ""
  cat "$HOME/.ssh/id_ed25519.pub" 2>/dev/null || cat "$HOME/.ssh/id_rsa.pub"
  echo ""
  echo "  4. Run: ./scripts/github_push.sh ssh"
  echo ""
  echo "Option B – HTTPS with GitHub CLI (no SSH key needed)"
  echo "  ~/bin/gh auth login"
  echo "  ./scripts/github_push.sh https"
}

case "$MODE" in
  ssh)
    ensure_remote "$SSH_REMOTE"
    if ssh_ok; then
      push_main
    else
      echo "SSH key not accepted by GitHub yet."
      show_ssh_help
      exit 1
    fi
    ;;
  https)
    ensure_remote "$HTTPS_REMOTE"
    if ! "$GH" auth status >/dev/null 2>&1; then
      echo "Login to GitHub first:"
      echo "  ~/bin/gh auth login"
      echo ""
      echo "Choose: GitHub.com → HTTPS → Login with browser"
      exit 1
    fi
    "$GH" auth setup-git
    push_main
    ;;
  auto)
    ensure_remote "$SSH_REMOTE"
    if ssh_ok; then
      push_main
      exit 0
    fi

    echo "SSH not configured."
    if "$GH" auth status >/dev/null 2>&1; then
      echo "Trying HTTPS with GitHub CLI..."
      ensure_remote "$HTTPS_REMOTE"
      "$GH" auth setup-git
      push_main
      exit 0
    fi

    show_ssh_help
    exit 1
    ;;
  *)
    echo "Usage: $0 [auto|ssh|https]"
    exit 1
    ;;
esac
