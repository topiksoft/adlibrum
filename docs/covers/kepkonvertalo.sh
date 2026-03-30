#!/bin/sh

for i in `ls *FA.png`
do

echo "Fájlnév: $i"
echo ""

i=$(echo $i | sed 's/-FA.png//')

convert -density 300 $i-FA.png $i-FB.jpg
echo "Az eredeti jpg változata (\"B\") elkészült.\n"

convert -density 300 $i-FA.png -resize 600x $i-FC.jpg
convert $i-FA.png -resize 600x png8:$i-FC.png
echo "A 600 képpont széles változat (\"C\" - katalógusképnek, 300dpi) elkészült.\n"

convert -density 300 $i-FA.png -resize 300x $i-FD.jpg
convert -density 300 $i-FA.png -resize 300x png8:$i-FD.png
echo "A 300 képpont széles változat (\"D\" - bolt nagykép) elkészült.\n"

convert -density 300 $i-FA.png -resize 200x $i-FE.jpg
convert -density 300 $i-FA.png -resize 200x png8:$i-FE.png
echo "A 200 képpont széles változat (\"E\" - weblap kiskép) elkészült.\n"

done
