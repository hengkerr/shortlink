<?php
$pdo = new PDO('mysql:host=localhost:3306;dbname=slug', 'root', '');
function generate_slug(){
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $slug = '';
    for ($i = 0; $i < 8; $i++){
        $slug .= $characters[rand(0, strlen($characters)-1)];
    }
    return $slug;
}
function get_short_urls(){
    global $pdo;
    $stmt = $pdo -> query('SELECT * FROM short_urls');
    return $stmt -> fetchAll(PDO::FETCH_ASSOC);
}
if(isset($_POST['LongUrl']) && isset($_POST['LongUrl'])){
    $LongUrl = $_POST['LongUrl'];
    $custom_slug = $_POST['custom_slug'];
    if($custom_slug){
        $slug = $custom_slug;
    } 
    else{
        $slug = generate_slug();
    }
    $stmt = $pdo -> prepare('INSERT INTO short_urls (LongUrl, slug) VALUES (?, ?)');
    $stmt -> execute([$LongUrl, $slug]);
    $short_url = 'http://' . $domain . '/' . $slug;
    header('Location: send.php');
}
if(isset($_GET['l'])){
    $slug = $_GET['l'];
    $stmt = $pdo->prepare('SELECT LongUrl FROM short_urls WHERE slug = ?');
    $stmt -> execute([$slug]);
    $LongUrl = $stmt->fetchColumn();
    if($LongUrl){
        $stmt = $pdo -> prepare('UPDATE short_urls SET slug = slug + 1 WHERE slug = ?');
        $stmt -> execute([$slug]);
        header("Location: $LongUrl");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>URL Shortener</title>
</head>
<body style="background: rgb(171,78,202); background: linear-gradient(90deg, rgba(171,78,202,1) 12%, rgba(71,159,198,1) 46%, rgba(27,199,227,1) 100%);">
<main class="m-3 d-block">
    <div class="container h-100 ">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 50px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
    <div class="background">
    <p class="text-center h2 fw-bold mb-5 mx-1 mx-md-4 mt-4">URL Shortener</p>
        <form method="post">
            <div style="margin-top: 10px;">
                <label for="LongUrl" class="form-label">Paste Long Url:</label>
            </div>
            <input type="text" name="LongUrl" id="LongUrl" class="form-control"><br>
            <div style="margin-top: 10px;">
                <label for="custom_slug" class="form-label">Slug Url:</label>
            </div>
            <input type="text" name="custom_slug" id="custom_slug" class="form-control"><br>
            <!-- <br> -->
            <div class="text-center h2 fw-bold mb-5 mx-1 mx-md-4 mt-4">
                <input type="submit" name="submit" value="Shorten URL" class="btn btn-primary btn-lg"></input>
            </div>
        </form>
        <?php if(isset($short_url)) : ?>
            <p>URL Pendek:</p>
            <a href="<?php echo $short_url; ?>" target="_blank"><?php echo $short_url; ?></a>
        <?php endif; ?>
        <h5>URL yang telah Dipersingkat</h5>
        <ul>
            <?php foreach (get_short_urls() as $url) : ?>
                <!-- <li> -->
                    <a href="<?php echo '?l='.$url['slug']; ?>" target="_blank">
                        <?php echo 'http://shortlink/' . $url['slug'];?>
                    </a>
                    (<?php echo $url['slug']; ?> Total Clicks)
                <!-- </li> -->
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
