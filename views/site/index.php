<?php

/* @var $this yii\web\View */

$this->title = 'Booky';
?>

<div class="row">

    <div class="col-md-3">
        <div class="list-group">
            <a href="#" class="list-group-item disabled">
                Categories
            </a>
            <?php foreach ($categoryAll as $category): ?>
                <a href="<?= Yii::$app->request->baseUrl ?>/site/index?id=<?= $category->id; ?>" class="list-group-item"><?= $category->name; ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach ($productAll as $product): ?>

    <div class="col-md-3">
        <div class="thumbnail">
            <img style="height: 200px" src="<?= Yii::$app->request->baseUrl; ?>/gallery/<?= ($product->image != null) ? $product->image : 'nocover.jpg'; ?>" alt="...">
            <div class="caption">
                <h3><?= $product->name; ?></h3>
                <p><?= substr($product->description, 0, 90) . '...'; ?></p>
                <p><a href="#" class="btn btn-primary" role="button">Download</a></p>
            </div>
        </div>
    </div>

    <?php endforeach; ?>

</div>

