<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .content{
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
</style>
</head>
<body>
     <?php require_once '../app/views/layout/partial/header.php'; ?>
    <div class="content">
    <?php require_once "../app/views/" . $viewName . ".php"; ?>
</div>
    <?php require_once '../app/views/layout/partial/footer.php'; ?>
</body>
</html>