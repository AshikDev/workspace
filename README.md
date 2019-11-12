**Download Yii Framework**
 - https://www.yiiframework.com/download
 
01. **Configure site** [config/web.php]
    - 'cookieValidationKey' => 'any thing',
    - Enable pretty url

02. **Designing User Interface** [ https://getbootstrap.com/docs/3.3/components/ ]
    * "List group" for left menu
    * "Thumbnail" for product list
    * Image: ```php echo Yii::$app->request->baseUrl;```

03. **Working with database**
    3.1 create a database "any_name"
    3.2 create a "user" table [8 columns]
        - id, first_name, last_name, email, username, password, authKey, accessToken
    3.3 create a "category" table [2 columns]
        - id, name
    3.4 create a "product" table [7 columns]
        - id, name, price, expire_date, description, image, category_id

04. Creating MVC (Model View Controller)
    4.1 rename UserModel.php 
    4.2 browse url/gii
    4.3 create Models
    4.4 create cruds

05. Authentication
    5.1 Add "Sign Up" at top menu
        - Yii::$app->user->isGuest ? (['label' => 'Signup', 'url' => ['/user/create']]) : (''),
    5.2 Update User Model, View, Controller
    5.3 Update User Model for logging in

06. Working with Products
    6.1 Add "Product" at top menu - https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu
    6.2 Add Category 
    6.3 Display Category at left
    6.4 Create product https://www.bookrix.com/books;short-story,id:55.html
    6.5 Add product
    6.6 Display at the home page

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