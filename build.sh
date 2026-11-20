#!/bin/bash
# Genera la versión estática del sitio en la carpeta docs/ para GitHub Pages.
set -e
cd "$(dirname "$0")"

rm -rf docs
mkdir docs

php index.php > docs/index.html
cp -R assets img docs/
echo "cabanaslaspleyades.cl" > docs/CNAME
touch docs/.nojekyll

echo "? Sitio generado en docs/"