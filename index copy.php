<?php
// PNG dosyanızın adı
$pngDosyaAdi = 'dosya.png';

// PNG dosyasını GD kütüphanesi ile yükleyelim
$im = imagecreatefrompng($pngDosyaAdi);

// PNG dosyasının genişlik ve yüksekliğini alalım
$genislik = imagesx($im);
$yukseklik = imagesy($im);

// SVG içeriği oluşturmak için string değişkeni
$svgIcerik = '<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
 "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="' . $genislik . 'pt" height="' . $yukseklik . 'pt" viewBox="0 0 ' . $genislik . ' ' . $yukseklik . '"
 preserveAspectRatio="xMidYMid meet">';

// PNG dosyasını SVG içeriğine dönüştürelim
for ($y = 0; $y < $yukseklik; $y++) {
    for ($x = 0; $x < $genislik; $x++) {
        // Pikselin renk bilgisini alalım
        $renk = imagecolorat($im, $x, $y);

        // R, G, B ve Alfa kanallarını alalım
        $r = ($renk >> 16) & 0xFF;
        $g = ($renk >> 8) & 0xFF;
        $b = $renk & 0xFF;
        $alfa = 1 - (($renk & 0x7F000000) >> 24) / 127;

        // SVG içeriğine ekleyelim
        $svgIcerik .= sprintf('<rect x="%d" y="%d" width="1" height="1" fill="rgba(%d, %d, %d, %f)" />', $x, $y, $r, $g, $b, $alfa);
    }
}

// SVG içeriğini tamamlayalım
$svgIcerik .= '</svg>';

// SVG dosyasını oluşturalım ve kaydedelim
$svgDosyaAdi = 'cikti.svg';
file_put_contents($svgDosyaAdi, $svgIcerik);

// Bellekten PNG kaynağını temizleyelim
imagedestroy($im);

echo "SVG dosyası başarılı bir şekilde oluşturuldu ve kaydedildi: $svgDosyaAdi";
?>
