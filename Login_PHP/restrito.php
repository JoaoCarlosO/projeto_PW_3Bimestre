<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

$imageDir = 'images/';

if (!isset($_SESSION['images'])) {
    $_SESSION['images'] = [];
    $files = scandir($imageDir);
    foreach ($files as $file) {
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
            $_SESSION['images'][] = $file;
        }
    }

    if (empty($_SESSION['images'])) {
        $_SESSION['images'] = ['img1.png', 'img2.png', 'img3.png', 'img4.png', 'img5.png'];
    }
}

function imageGallery($action = null, $imageDir) {
    $images = &$_SESSION['images'];

    switch ($action) {
        case 'sort':
            sort($images);
            break;
        case 'add':
            array_push($images, 'img6.png');
            break;
        case 'duplicate':
            if (!empty($images)) {
                $last_image = end($images);
                array_push($images, $last_image);
            }
            break;
        case 'remove':
            if (count($images) > 0) {
                array_shift($images);
            }
            break;
        case 'reverse':
            $images = array_reverse($images);
            break;
    }

    $image_count = count($images);

    echo "<div class='galeria'>";
    if ($image_count > 0) {
        foreach ($images as $image) {
            echo "<img src='{$imageDir}$image' alt='Image' class='img-fluid' style='max-width: 250px; max-height: 250px; margin-right: 10px; margin-bottom: 10px; margin-top: 50px'>";
        }
    } else {
        echo "<p class='text-center text-white fs-5'>Não há imagens na galeria.</p>";
    }
    echo "</div>";

    echo "<p class='text-center text-white mt-5 fs-5'>Total de imagens: $image_count</p>";
}

$action = isset($_POST['action']) ? $_POST['action'] : null;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Restrita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center fs-1 text-white">Bem-vindo</h2>
        <p class="text-center fs-4 text-white">Manipule a galeria de imagens abaixo:</p>
        <form method="POST" class="mb-3 text-center">
            <button type="submit" name="action" value="sort" class="btn btn-danger text-center me-3">Ordenar Imagens</button>
            <button type="submit" name="action" value="add" class="btn btn-danger text-center me-3">Adicionar Imagem</button>
            <button type="submit" name="action" value="duplicate" class="btn btn-danger text-center">Duplicar Última Imagem</button>
            <button type="submit" name="action" value="remove" class="btn btn-danger text-center ms-3">Remover Primeira Imagem</button>
            <button type="submit" name="action" value="reverse" class="btn btn-danger text-center ms-3">Inverter Ordem das Imagens</button>
        </form>
        <?php imageGallery($action, $imageDir); ?>
    </div>
</body>
</html>
