## Documentation of Booky Content Management System

**Download Yii Framework**
 - https://www.yiiframework.com/download
 
01. **Configure site** [config/web.php]
    * set cookie validation key
    ```'cookieValidationKey' => 'anyThing',```
    * browse the site: http://localhost/booky/web/
    * Enable pretty url by uncommenting this section
    ```
    'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
    ```
    
02. **Designing User Interface** [ https://getbootstrap.com/docs/3.3/components/ ]
    * "List group" for left menu
    * "Thumbnail" for product list
    * create a ""gallery" folder under "web" directory
    * Set a default Image [views/site/index.php]: 
    ``` 
    <img src="<?= Yii::$app->request->baseUrl; ?>/gallery/nocover.jpg"> 
    ```

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
    * browse http://localhost/booky/web/gii
    * create Models
    * create CRUDS

05. **Authentication**
    * in top navigation [views/layouts/main.php]
    ``` 
    // Adding "Sign Up" at top menu
    Yii::$app->user->isGuest ? (['label' => 'Signup', 'url' => ['/user/create']]) : (''), 
    ```
    * in model [models/User.php] 
    ``` 
    // copy implements IdentityInterface 
    // from old UserAnyname.php
    class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
    // in rules() method
    [['email'], 'email'], // accept only email
    ```
    * Copy all the function from old UserAnyname.php and then
    ``` 
    // in findIdentity($id) method
    return User::find()->where(['id' => $id])->one(); 
    ```
    ```
    // in findIdentityByAccessToken($token, $type = null) method
    return User::find()->where(['accessToken' => $token])->one();
    ```
    ```
    // in findByUsername($username)
    return User::find()->where(['username' => $username])->one(); 
    ```

    * in controller [controllers/UserController.php]
    ``` 
    // in actionCreate() method
    // Display a success message on submission of Sign Up
    Yii::$app->session->setFlash('success', 'Congratulation! You account has been created.'); 
    ```
    
06. **Working with Products**
    * Add "Product" item at the top menu [ layouts/main.php from https://www.yiiframework.com/doc/api/2.0/yii-widgets-menu ]
    * Create Category: http://localhost/booky/web/category/create
    * Display Category list: http://localhost/booky/web/category/index
    * Create product: http://localhost/booky/web/product/create
        * resource - https://www.bookrix.com/books;short-story,id:55.html
    * Display product list: http://localhost/booky/web/product/index
    * Display category at the home page as leftview 
        * in controller [controllers/SiteController.php]
        ```
        // in actionIndex()
        $categoryAll = Category::find()->all();
        ```
        * in view [views/site/index]
        ```
        <?php foreach ($categoryAll as $category): ?>
            <a href="<?= Yii::$app->request->baseUrl ?>/site/index?id=<?= $category->id; ?> class="list-group-item"><?= $category->name; ?></a>
        <?php endforeach; ?>
        ```
    * Display product at the home page as gridview
        * in controller
        ```
        // in actionIndex()
        $productAll = Product::find()->all();
        ```
        ``` 
            <?php foreach ($productAll as $product): ?>
          
              <div class="col-sm-3 col-md-3">
                  <div class="thumbnail">
                      <img style="height: 200px" src="<?= Yii::$app->request->baseUrl; ?>/gallery/nocover.jpg" alt="...">
                      <div class="caption">
                          <h3><?= $product->name; ?></h3>
                          <p><?= substr($product->description, 0, 90) . '...'; ?></p>
                          <p><a href="#" class="btn btn-primary" role="button">Download</a></p>
                      </div>
                  </div>
              </div>
          
            <?php endforeach; ?> 
        ```

07. **Working with image upload**
    * in model [models/Product.php]
    ```
    [['image'], 'file', 'skipOnEmpty' => true],
    ```
    * in controller [controller/ProductController.php]
    ```
    // in class:  
    use use yii\web\UploadedFile;
    // in actionCreate() and actionUpdate(): 
    $upload = UploadedFile::getInstance($model, 'image');
    $model->image = time() . Yii::$app->user->identity->id . '.' . $upload->extension;
    $upload->saveAs(Yii::getAlias('@app/web/gallery') . '/' . $model->image);
    ```
    * in view [views/create.php rendering _form.php]
    ```
    'options' => ['enctype' => 'multipart/form-data'] (in _form.php)
    ```
    ```
    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']); ?>
    ```
    * in home page [views/create.php rendering _form.php]
    ```
    <?= Yii::$app->request->baseUrl; ?>/gallery/<?= ($product->image != null) ? $product->image : 'nocover.jpg'; ?>
    ```

08. **Dropdown list** 
    * in controller [controllers/ProductController.php]
    ```
    // in actioCreate() and actionUpdate() methods
    $categoryAll = Category::find()->all();
    $categoryArray = ArrayHelper::map($categoryAll, 'id', 'name');
    ```
    * in view [views/product/create.php rendering _form.php]
    ```
    <?= $form->field($model, 'category_id')->dropDownList($categoryArray, ['prompt' => 'Select a category']); ?>
    ```

09. **Datepicker**
    * download composer [https://getcomposer.org/download/]
    * CMD ``` composer require --prefer-dist yiisoft/yii2-jui "*" ```
    * in view [views/product/create.php rendering _form.php]
    ```
    use yii\jui\DatePicker;
    <?= $form->field($model, 'expire_date')->widget(DatePicker::class, [
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['autocomplete' => 'off'],
        'clientOptions' => [
            'minDate' => '+0'
        ]
     ]); ?>
    ``` 
    
10. **Home Task** 
    * Show detail view of the product while clicking on the product name
    * User will be able to upload PDF as a book while adding product
    * Activate "Download" button for that PDF "Book"
    
**Extras (Git):**
    * sudo git clone https://github.com/AshikDev/workspace.git booky
    * sudo git init
    * sudo git add .
    * sudo git commit -m "Version Number"
    * sudo git remote add origin https://github.com/AshikDev/workspace.git
    * sudo git push origin master