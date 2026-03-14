#!/usr/bin/env bash
# =============================================================================
# ColibriWP → Brixly Rebrand Script
# GPL v3 Fork — Run this ONCE from the repo root after cloning.
# Usage: bash rebrand-to-brixly.sh
# =============================================================================

set -e

ORIGINAL_DIR="colibri-wp"
NEW_DIR="brixly"

echo "============================================="
echo "  Brixly Rebrand Script"
echo "  ColibriWP → Brixly"
echo "============================================="

# ---------------------------------------------------------------------------
# 1. SAFETY CHECK
# ---------------------------------------------------------------------------
if [ ! -d "$ORIGINAL_DIR" ]; then
  echo "ERROR: '$ORIGINAL_DIR' directory not found."
  echo "Make sure you're running this from the repo root."
  exit 1
fi

if [ -d "$NEW_DIR" ]; then
  echo "ERROR: '$NEW_DIR' directory already exists. Aborting to avoid overwrite."
  exit 1
fi

# ---------------------------------------------------------------------------
# 2. COPY (don't destroy the original — keep it for diffing/reference)
# ---------------------------------------------------------------------------
echo ""
echo "Step 1/5 — Copying '$ORIGINAL_DIR' → '$NEW_DIR' ..."
cp -r "$ORIGINAL_DIR" "$NEW_DIR"
echo "Done."

# ---------------------------------------------------------------------------
# 3. RENAME FILES & FOLDERS that contain 'colibri' in their name
# ---------------------------------------------------------------------------
echo ""
echo "Step 2/5 — Renaming files and folders ..."

# Process deepest paths first (reverse sort) so parent renames don't break children
find "$NEW_DIR" -depth -name "*colibri*" | sort -r | while IFS= read -r filepath; do
  newpath=$(echo "$filepath" | sed \
    -e 's/colibri-wp/brixly/g' \
    -e 's/colibriWP/brixlyWP/g' \
    -e 's/ColibriWP/BrixlyWP/g' \
    -e 's/colibri/brixly/g' \
    -e 's/Colibri/Brixly/g')
  if [ "$filepath" != "$newpath" ]; then
    mv "$filepath" "$newpath"
    echo "  Renamed: $filepath → $newpath"
  fi
done
echo "Done."

# ---------------------------------------------------------------------------
# 4. FIND & REPLACE INSIDE ALL FILES
# ---------------------------------------------------------------------------
echo ""
echo "Step 3/5 — Replacing strings inside files ..."

# Detect OS for sed -i compatibility (macOS needs '' after -i)
if sed --version 2>/dev/null | grep -q GNU; then
  SED_INPLACE="sed -i"
else
  SED_INPLACE="sed -i ''"
fi

do_replace() {
  find "$NEW_DIR" -type f \( \
    -name "*.php" -o \
    -name "*.css" -o \
    -name "*.js" -o \
    -name "*.json" -o \
    -name "*.txt" -o \
    -name "*.md" -o \
    -name "*.pot" -o \
    -name "*.po" -o \
    -name "*.html" \
  \) | while IFS= read -r file; do
    $SED_INPLACE \
      -e 's/ColibriWP/BrixlyWP/g' \
      -e 's/colibriwp/brixly/g' \
      -e 's/colibri-wp/brixly/g' \
      -e 's/colibri_wp/brixly/g' \
      -e 's/COLIBRI_WP/BRIXLY/g' \
      -e 's/COLIBRIWP/BRIXLY/g' \
      -e 's/colibri_apply_filters/brixly_apply_filters/g' \
      -e 's/colibri_do_action/brixly_do_action/g' \
      -e 's/colibri_/brixly_/g' \
      -e 's/Colibri\b/Brixly/g' \
      -e 's/colibri\b/brixly/g' \
      -e 's/static\.colibriwp\.com/static.brixly.com/g' \
      -e 's/colibriwp\.com/brixly.com/g' \
      "$file"
  done
}

do_replace
echo "Done."

# ---------------------------------------------------------------------------
# 5. UPDATE THE THEME HEADER IN style.css
# ---------------------------------------------------------------------------
echo ""
echo "Step 4/5 — Updating style.css theme header ..."

STYLE_CSS="$NEW_DIR/style.css"

if [ -f "$STYLE_CSS" ]; then
  $SED_INPLACE \
    -e 's/^Theme Name:.*$/Theme Name: Brixly/' \
    -e 's/^Theme URI:.*$/Theme URI: https:\/\/brixly.com/' \
    -e 's/^Author:.*$/Author: Your Name or Company/' \
    -e 's/^Author URI:.*$/Author URI: https:\/\/brixly.com/' \
    -e 's/^Description:.*$/Description: Brixly is a flexible, multipurpose WordPress theme with a powerful Customizer-based page builder./' \
    -e 's/^Version:.*$/Version: 1.0.0/' \
    -e 's/^Text Domain:.*$/Text Domain: brixly/' \
    "$STYLE_CSS"
  echo "Done."
else
  echo "WARNING: style.css not found at $STYLE_CSS — skipping theme header update."
fi

# ---------------------------------------------------------------------------
# 6. ADD YOUR COPYRIGHT NOTICE TO style.css
# ---------------------------------------------------------------------------
echo ""
echo "Step 5/5 — Appending Brixly copyright notice to style.css ..."

cat >> "$STYLE_CSS" << 'EOF'

/*
 * Brixly Theme — Copyright (C) 2026 Your Name or Company
 * Brixly is a fork of ColibriWP Theme, Copyright (C) 2019 ExtendThemes
 * Original: https://github.com/ExtendStudio/colibri-wp
 * Licensed under the GNU General Public License v3 or later.
 * See LICENSE file for full license text.
 *
 * Changes: Rebranded from ColibriWP to Brixly. UI/UX redesign,
 * new features, and bug fixes by [Your Name/Company].
 */
EOF

echo "Done."

# ---------------------------------------------------------------------------
# SUMMARY
# ---------------------------------------------------------------------------
echo ""
echo "============================================="
echo "  Rebrand complete!"
echo "============================================="
echo ""
echo "Your rebranded theme is in: ./$NEW_DIR"
echo "The original is untouched in: ./$ORIGINAL_DIR"
echo ""
echo "NEXT STEPS:"
echo "  1. Open $NEW_DIR/style.css and confirm the theme header looks right"
echo "  2. Search for any remaining 'colibri' references:"
echo "       grep -ri 'colibri' $NEW_DIR --include='*.php'"
echo "  3. Update $NEW_DIR/functions.php — check the main theme class name"
echo "  4. Replace any Colibri logo images in $NEW_DIR/resources/images/"
echo "  5. Update the README.md with Brixly info"
echo "  6. Run: cd $NEW_DIR && composer install && npm install && npm run build"
echo "  7. Test by installing in WordPress"
echo ""
echo "Remember: Keep the original ExtendThemes copyright notices in place."
echo "You can ADD yours, but not REMOVE theirs (GPL v3 requirement)."
echo ""
