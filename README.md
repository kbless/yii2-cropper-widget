# yii2-cropper-widget
Yii2 Image Cropper Input Widget

[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg)](https://php.net/)

<a href="https://fengyuanchen.github.io/cropper/" target="_blank">Cropper.js  v4.0.0</a> - Bootstrap Cropper (recommended) (already included).

Features
------------
+ Image Crop
+ Image Rotate
+ Image Flip
+ Image Zoom
+ Image Reset
+ Coordinates
+ Image Sizes Info 
+ Base64 Data
+ Upload
+ Delete Img

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist potime/yii2-cropper-widget "dev-master"
```

or add

```
"potime/yii2-cropper-widget": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Let's add into config in your main-local config file before return[]
````php
Yii::setAlias('@uploadPath', realpath(dirname(__FILE__).'/../../uploads/'));
````

Let's add in your model file
````php
public $_image;

public function rules()
{
    return [
        ['_image', 'safe'],
    ];
}

public function beforeSave($insert)
{
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $this->_image, $result)){

        $type = $result[2];
        $data = base64_decode(str_replace($result[1], '', $this->_image));
        $path = Yii::getAlias('@uploadPath') . '/';
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, 0777);
        }
        $fileName= Yii::$app->security->generateRandomString() . '.' .$type;

        if (file_put_contents($path.$fileName, $data)) {
            // deleting old image
            if (!$this->isNewRecord && !empty($this->image)) {
                @unlink($path . $this->portrait);
            }

            // set new filename
            $this->image = $fileName;
        }
    }

    parent::beforeSave($insert);
}
````

Simple usage in _form file
-----
````php
 echo $form->field($model, '_image')->widget(\potime\cropper\Cropper::className(), [
        'label' => 'Select Image', 
        'imageUrl' => $model->_image,
        'cropperOptions' => [
            'width' => 255,
            'height' => 150,
            'preview' => [
                'width' => 255,
                'height' => 150,
            ],
        ],
]);
````

Advanced usage in _form file
-----
````php
 echo $form->field($model, '_image')->widget(\potime\cropper\Cropper::className(), [
    /*
     * elements of this widget
     *
     * buttonId          = #cropper-select-button-$uniqueId
     * previewId         = #cropper-result-$uniqueId
     * modalId           = #cropper-modal-$uniqueId
     * imageId           = #cropper-image-$uniqueId
     * inputChangeUrlId  = #cropper-url-change-input-$uniqueId
     * closeButtonId     = #close-button-$uniqueId
     * cropButtonId      = #crop-button-$uniqueId
     * browseInputId     = #cropper-input-$uniqueId // fileinput in modal
    */
    'uniqueId' => 'image_cropper', // will create automaticaly if not set
    // you can set image url directly
    // you will see this image in the crop area if is set
    // default null
    'imageUrl' => Yii::getAlias('@web/image.jpg'),

    'cropperOptions' => [
        'width' => 100, // must be specified
        'height' => 100, // must be specified
        // optional
        // url must be set in update action
        'preview' => [
            'url' => '', // (!empty($model->image)) ? Yii::getAlias('@uploadUrl/'.$model->image) : null
            'width' => 100, // must be specified // you can set as string '100%'
            'height' => 100, // must be specified // you can set as string '100px'
        ],
        // optional // default following code
        // you can customize 
        'buttonCssClass' => 'btn btn-primary',
        // optional // defaults following code
        // you can customize 
        // "zoom-in" => false hide button
        'icons' => [
            'browse' => '<i class="fa fa-image"></i>',
            'crop' => '<i class="fa fa-crop"></i>',
            'close' => '<i class="fa fa-crop"></i>',       
            'zoom-in' => '<i class="fa fa-search-plus"></i>',
            'zoom-out' => '<i class="fa fa-search-minus"></i>',
            'rotate-left' => '<i class="fa fa-rotate-left"></i>',
            'rotate-right' => '<i class="fa fa-rotate-right"></i>',
            'flip-horizontal' => '<i class="fa fa-arrows-h"></i>',
            'flip-vertical' => '<i class="fa fa-arrows-v"></i>',
            'move-left' => '<i class="fa fa-arrow-left"></i>',
            'move-right' => '<i class="fa fa-arrow-right"></i>',
            'move-up' => '<i class="fa fa-arrow-up"></i>',
            'move-down' => '<i class="fa fa-arrow-down"></i>',
            'reset' => '<i class="fa fa-refresh"></i>',
            'delete' => '<i class="fa fa-trash"></i>',
        ],
        // you can customize your upload options
        'uploadOptions'=>[
            'url'=>'/upload/base64-img',
            'response'=>'res.result.url'
        ]
    ],

    'modalOptions' => [
            'title' => 'Image Crop Editor', // Modal header Title
            
            // optional // defaults following code
            // you can customize 
            'labels' => [ // default name
                'browse' => 'Browse',
                'crop' => 'Crop & Save',
                'close' => 'Colse',  
                'reset' => 'Reset',
                'delete' => 'Delete',
            ],
        ],

    // optional // defaults following code
    // you can customize 
    'label' => 'Select Image', 
    
    // optional // default following code
    // you can customize 
    'template' => '{button}{preview}',
 ]);
````

jsOptions[]
-----
````php
 echo $form->field($model, '_image')->widget(\potime\cropper\Cropper::className(), [
    'cropperOptions' => [
        'width' => 100, // must be specified
        'height' => 100, // must be specified
     ],
     'jsOptions' => [
        'pos' => View::POS_END, // default is POS_END if not specified
        'onClick' => 'function(event){
              // when click crop or close button 
              // do something 
        }'        
     ],
]);
````

Notes
-----

You can set crop image directly with javascript 

Sample:
````
$('button').click(function() {
   // #cropper-modal-$unique will show automatically when click the button
   
   // you must set uniqueId on widget
   $('#cropper-url-change-input-' + uniqueId).val('image.jpeg').trigger('change');   
});
````

Thx
-----

 [bilginnet](https://github.com/bilginnet/yii2-cropper).
 
 [crazykun](https://github.com/crazykun/yii2-cropper).

