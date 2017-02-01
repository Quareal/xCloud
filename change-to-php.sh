#!/bin/bash
echo "*.css linguist-language=php" >> .gitattributes
git add .
git commit -m "gitattributes"
git push
