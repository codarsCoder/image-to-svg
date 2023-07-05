<?php
// PNG dosyanızın adı
$pngDosyaAdi = 'dosya.png';

// PNG dosyasını GD kütüphanesi ile yükleyelim
$im = imagecreatefrompng($pngDosyaAdi);

// PNG dosyasının genişlik ve yüksekliğini alalım
$genislik = imagesx($im);
$yukseklik = imagesy($im);

// Hedeflenen renk (beyaz için RGB: 255, 255, 255)
$hedefR = 255;
$hedefG = 255;
$hedefB = 255;

// PNG dosyasındaki renkleri hedef renge dönüştürelim
imagefilter($im, IMG_FILTER_COLORIZE, $hedefR - 0, $hedefG - 0, $hedefB - 0);

// SVG içeriği oluşturmak için string değişkeni
$svgIcerik = '<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
 "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="' . $genislik . 'pt" height="' . $yukseklik . 'pt" viewBox="0 0 ' . $genislik . ' ' . $yukseklik . '"
 preserveAspectRatio="xMidYMid meet">';

// PNG dosyasını SVG içeriğine dönüştürelim
$base64 = base64_encode(file_get_contents($pngDosyaAdi));
$svgIcerik .= '<image x="0" y="0" width="' . $genislik . '" height="' . $yukseklik . '" href="data:image/png;base64,' . $base64 . '" />';

// SVG içeriğini tamamlayalım
$svgIcerik .= '</svg>';

// SVG dosyasını oluşturalım ve kaydedelim
$svgDosyaAdi = 'cikti.svg';
file_put_contents($svgDosyaAdi, $svgIcerik);

// Bellekten PNG kaynağını temizleyelim
imagedestroy($im);

echo "SVG dosyası başarılı bir şekilde oluşturuldu ve kaydedildi: $svgDosyaAdi";
?>
