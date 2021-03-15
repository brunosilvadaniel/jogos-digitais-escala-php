<?php
    error_reporting(-1);
    ini_set('display_erros', 'On');

    $escala = $_REQUEST['escala'];

    $imagem = imagecreatefromstring(file_get_contents('https://i.imgur.com/BbFpphk.png'));
    $tamanho = getimagesize('https://i.imgur.com/BbFpphk.png');
    $cores = [];

    $novaImagem = imagecreatetruecolor(
        intval($tamanho[0] * $escala),
        intval($tamanho[1] * $escala)
    );

    for($x = 0; $x < $tamanho[0]; $x++) {
        for($y = 0; $y < $tamanho[1]; $y++) {
            $cor = imagecolorat($imagem, $x, $y);
            $r = ($cor >> 16) & 0xFF;
            $g = ($cor >> 8) & 0xFF;
            $b = $cor & 0xFF;
            $cores[$x][$y] = imagecolorallocate($novaImagem, $r ,$g ,$b);
        }
    }

    for($x = 0; $x < intval($tamanho[0] * $escala); $x++) {
        for($y = 0; $y < intval($tamanho[1] * $escala); $y++) {
            imagesetpixel(
                $novaImagem, 
                $x, 
                $y, 
                $cores[intval($x/$escala)][intval($y/$escala)]
            );
        }
    }

    header('Content-Type: image/png');
    imagepng($novaImagem);
    exit;
?>
