**Download Yii Framework**
 - https://www.yiiframework.com/download
 
01. **Configure site** [config/web.php]
    - 'cookieValidationKey' => 'any thing',
    - Enable pretty url

02. **Designing User Interface** [ https://getbootstrap.com/docs/3.3/components/ ]
    * "List group" for left menu
    * "Thumbnail" for product list
    * Image [views/site/index.php]: ``` <img src="<?= Yii::$app->request->baseUrl; ?>/img/nocover.jpg"> ```

03. **Working with database**
    * create a database "any_name"
    * create a "user" table [8 columns]
        * id, first_name, last_name, email, username, password, authKey, accessToken
    * create a "category" table [2 columns]
        * id, name
    * create a "product" table [7 columns]
        * id, name, price, expire_date, description, image, category_id

04. **Creating MVC (Model View Controller)**
    * rename User.php as UserAnyName.php [models/User.php]
    * browse url/gii
    * create Models
    * create CRUDS

05. Authentication
    * Add "Sign Up" at top menu [views/layouts/main.php]
        * ``` Yii::$app->user->isGuest ? (['label' => 'Signup', 'url' => ['/user/create']]) : (''), ```
    * Display a success message on submission of Sign Up
        * ``` Yii::$app->session->setFlash('success', 'Congratulation! You account has been created.'); ```
    * Update Model [models/User.php]
        * class User: ``` implements \yii\web\IdentityInterface ```
        * findIdentity: ``` return User::find()->where(['id' => $id])->one(); ```
        * findIdentityByAccessToken: ``` return User::find()->where(['accessToken' => $token])->one(); ```
        * findByUsername: ``` return User::find()->where(['username' => $username])->one(); ```

06. **Working with Products**
    * Add "Product" item at the top menu [ layouts/main.php from https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu ]
    * Create Category: http://localhost/booky/web/category/create
    * Display Category list: http://localhost/booky/web/category/index
    * Create product: http://localhost/booky/web/product/create
        * resource - https://www.bookrix.com/books;short-story,id:55.html
    * Display product list: http://localhost/booky/web/product/index
    * Display category at the home page as leftview
        * ```<?php foreach ($categoryAll as $category): ?>
                <a href="<?= Yii::$app->request->baseUrl ?>/site/index?id=<?= $category->id; ?>" class="list-group-item"><?= $category->name; ?></a>
          <?php endforeach; ?>```

07. Working with image upload
    7.1 in model
        - [['image'], 'file', 'skipOnEmpty' => true],
    7.3 in controller 
        - $upload = UploadedFile::getInstance($model, 'image');
        - $model->image = time() . Yii::$app->user->identity->id . '.' . $upload->extension;
        - $upload->saveAs(Yii::getAlias('@app/web/gallery') . '/' . $model->image);
    7.2 in view 
        - 'options' => ['enctype' => 'multipart/form-data'] (in _form.php)
        - <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']); ?> (in _form.php)
        - <?= Yii::$app->request->baseUrl; ?>/gallery/<?= ($product->image != null) ? $product->image : 'nocover.jpg'; ?> (in index.php)

08. Dropdown list 
    8.1 in controller
        - $categoryAll = Category::find()->all();
        - $categoryArray = ArrayHelper::map($categoryAll, 'id', 'name');
    8.2 in view 
        - <?= $form->field($model, 'category_id')->dropDownList($categoryArray, ['prompt' => 'Select a category']); ?>

09. Datepicker
    9.1 download composer
        - https://getcomposer.org/download/
    9.2 composer require --prefer-dist yiisoft/yii2-jui "*"
    9.3 in view
        - use yii\jui\DatePicker;
        - <?= $form->field($model, 'expire_date')->widget(DatePicker::class, [
            'language' => 'en',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['autocomplete' => 'off'],
            'clientOptions' => [
                'minDate' => '+0'
            ]
         ]) ?>