<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Görselin geçerli bir dosya olduğunu kontrol edin
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Geçici dosya yolunu alın
        $tmpFilePath = $_FILES['image']['tmp_name'];

        // Geçici dosyayı SVG'ye dönüştürün ve renkleri değiştirin
        $image = imagecreatefrompng($tmpFilePath);

        // Yeni bir boş SVG dosyası oluşturun
        $svg = new DOMDocument();
        $svg->appendChild($svg->createElement('svg'));

        // Görsel boyutlarını SVG'ye ayarlayın
        $width = imagesx($image);
        $height = imagesy($image);
        $svg->documentElement->setAttribute('width', $width);
        $svg->documentElement->setAttribute('height', $height);

        // Her pikseli SVG'ye ekleyin ve renklerini değiştirin
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Renk kodunu SVG fill özelliği olarak ayarlayın
                // $fill = sprintf('#%02x%02x%02x', $r, $g, $b);
                $fill = '#000000'; 

                // Yeni bir SVG path öğesi oluşturun ve fill özelliğini ayarlayın
                $path = $svg->createElement('path');
                $path->setAttribute('fill', $fill);

                // Pikselin koordinatlarını ayarlayın ve SVG'ye ekleyin
                $path->setAttribute('d', "M$x $y");
                $svg->documentElement->appendChild($path);
            }
        }

        // SVG dosyasını kaydedin
        $svgPath = __DIR__ . '/image.svg';
        $svg->save($svgPath);

        // Belleği serbest bırakın
        imagedestroy($image);

        echo 'Görsel başarıyla SVG formatına dönüştürüldü ve renkler değiştirildi.';
    } else {
        echo 'Görsel yüklenirken bir hata oluştu.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Görsel Dönüştürme</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image">
        <button type="submit">Gönder</button>
    </form>
</body>
</html>
