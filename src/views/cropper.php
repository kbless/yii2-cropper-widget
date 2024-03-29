<?php
/** @var $this View */
/** @var $model \yii\db\ActiveRecord */
/** @var $name string */
/** @var $attribute string */
/** @var $value mixed */
/** @var $label mixed */
/** @var $uniqueId string */
/** @var $imageUrl string */
/** @var $cropperOptions mixed */
/** @var $modalOptions mixed */
/** @var $jsOptions mixed */
/** @var $template string */
/** @var $noImage string */
/** @var $uploadOptions mixed */


use yii\bootstrap\Html;
use yii\web\View;

switch ($jsOptions['pos']) {
    default:
    case View::POS_END:
        \potime\cropper\CropperAsset::register($this);
        break;
    case View::POS_BEGIN:
        \potime\cropper\CropperBeginAsset::register($this);
        break;
    case View::POS_HEAD:
        \potime\cropper\CropperHeadAsset::register($this);
        break;
    case View::POS_LOAD:
        \potime\cropper\CropperLoadAsset::register($this);
        break;
    case View::POS_READY:
        \potime\cropper\CropperReadyAsset::register($this);
        break;
}


$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];
$aspectRatio = $cropWidth / $cropHeight;
$browseLabel = $cropperOptions['icons']['browse'] . ' ' . ($modalOptions['labels']['browse'] ?? Yii::t('cropper', 'Browse'));
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Crop'));
$closeLabel = $cropperOptions['icons']['close'] . ' ' . ($modalOptions['labels']['close'] ?? Yii::t('cropper', 'Crop') . ' & ' . Yii::t('cropper', 'Close'));
$cropReset=$cropperOptions['icons']['reset'] . ' ' .  ($modalOptions['labels']['reset'] ?? Yii::t('cropper', 'Reset'));
$cropDelete=$cropperOptions['icons']['delete'] . ' ' .  ($modalOptions['labels']['delete'] ?? Yii::t('cropper', 'Delete'));
$uploadUrl=$uploadOptions['url'];
$uploadMethod=$uploadOptions['method'];
$uploadResponse=$uploadOptions['response'];

if ($label !== false) $browseLabel = $cropperOptions['icons']['browse'] . ' ' . $label;

// button template
$buttonContent = Html::button($browseLabel, [
    'class' => $cropperOptions['buttonCssClass'],
    'data-toggle' => 'modal',
    'data-target' => '#cropper-modal-' . $uniqueId,
    //'data-keyboard' => 'false',
    'data-backdrop' => 'static',
    'id' => 'cropper-select-button-' . $uniqueId,
]);

// preview template
$previewContent = null;
$previewOptions = $cropperOptions['preview'];
if ($cropperOptions['preview'] !== false) {
    $previewWidth = $previewOptions['width'];
    $previewHeight = $previewOptions['height'];    
    if(!isset($previewOptions['url'])||!$previewOptions['url']){
        $src=$noImage;
        $previewImage = Html::img($src, ['id' => 'cropper-image-'.$uniqueId, 'style' => "width: 128px; height: 128px;"]);
    }else{
        $src = $previewOptions['url'];
        $previewImage = Html::img($src, ['id' => 'cropper-image-'.$uniqueId, 'style' => "width: $previewWidth; height: $previewHeight;"]);
    }
    $previewContent = '<div class="cropper-container clearfix">' .        
        Html::tag('div', $previewImage, [
            'id' => 'cropper-result-'.$uniqueId,
            'class' => 'cropper-result',
            'style' => "",
            'data-buttonid' => 'cropper-select-button-' . $uniqueId,
            'onclick' => 'js: $("#cropper-select-button-'.$uniqueId.'").click()',
        ]) .
        // '<a  class="cropper-delete" id="cropper-delete-'.$uniqueId.'">×</a>'.
    '</div>';
} else {
    $previewContent = Html::img(null, ['class' => 'hidden', 'id' => 'cropper-image-'.$uniqueId]);
}

// input template
if (!empty($name)) {
    $input = Html::tag('div', Html::input('text', $name, $value, [
        'id' => $uniqueId.'-input',
        'class' => 'hidden'
    ]), ['id' => $uniqueId, 'class' => '',]);
    $inputId = $uniqueId.'-input';
} else {
    $input = Html::tag('div', Html::activeTextInput($model, $attribute, [
        'value' => $value,
        'class' => 'hidden',
    ]), ['id' => $uniqueId, 'class' => '',]);
    $inputId = Html::getInputId($model, $attribute);
}


// set template
$template = str_replace('{button}',  $input . $buttonContent, $template);
$template = str_replace('{preview}', $previewContent, $template);
?>

<div class="cropper-wrapper clearfix">
    <?php echo $template ?>
    <?= Html::hiddenInput('url-change-input-' . $uniqueId, '', [
        'id' => 'cropper-url-change-input-' . $uniqueId,
    ]) ?>
</div>

<?php
if ($cropperOptions['preview'] !== false) {

    $this->registerCss('
    .cropper-result {
        margin-top: 10px; 
        border: 1px dotted #bfbfbf; 
        background-color: #f5f5f5;
        position: relative;   
        cursor: pointer;     
    }');


}
?>
<?php $this->registerCss('
    .cropper-container{
        
    }
    .cropper-result {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
        position: relative;
        display: table;
        padding:10px;
    }
    .cropper-result img{
    }
    #cropper-modal-'.$uniqueId.' img{
        max-width: 100%;
    }
    #cropper-modal-'.$uniqueId.' .btn-file {
        position: relative;
        overflow: hidden;
    }
    #cropper-modal-'.$uniqueId.' .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    #cropper-modal-'.$uniqueId.' .input-group .input-group-addon {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #efefef;
        color: #555;
    }
    #cropper-modal-'.$uniqueId.' .height-warning.has-success .input-group-addon,
    #cropper-modal-'.$uniqueId.' .width-warning.has-success .input-group-addon{
        background-color: #00a65a;
        border-color: #00a65a;
        color: #fff;
    }
    #cropper-modal-'.$uniqueId.' .height-warning.has-error .input-group-addon,
    #cropper-modal-'.$uniqueId.' .width-warning.has-error .input-group-addon{
        background-color: #dd4b39;
        border-color: #dd4b39;
        color: #fff;
    }
    #cropper-modal-cropper_'.$uniqueId.'  .modal-body{
        padding:10px;
    }
    .cropper-delete{
        position:absolute;
        left:0;
        top:0;
        height:30px;
        width:30px;
        font-size: 21px;
        font-weight: bold;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;        
    }
    .cropper-delete:hover{
        color: #000;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: .5;
    }

') ?>


<?php
$modal = $this->render('modal', [
    'unique' => $uniqueId,
    'cropperOptions' => $cropperOptions,
    'modalOptions' => $modalOptions,
]);


$this->registerJs(<<<JS

    $('body').prepend('$modal');

    var options_$uniqueId = {
        croppable: false,
        croppedCanvas: '',
        
        element: {
            modal: $('#cropper-modal-$uniqueId'),
            image: $('#cropper-image-$uniqueId'),
            _image: document.getElementById('cropper-image-$uniqueId'),            
            result: $('#cropper-result-$uniqueId')
        },
        
        input: {
            model: $('#$inputId'),
            crop: $('#cropper-input-$uniqueId'),
            urlChange: $('#cropper-url-change-input-$uniqueId')
        },
        
        button: {
            crop: $('#crop-button-$uniqueId'),
            reset: $('#reset-button-$uniqueId'),
            delete: $('#delete-button-$uniqueId'),
            close: $('#close-button-$uniqueId')
        },
        
        data: {
            cropWidth: $cropWidth,
            cropHeight: $cropHeight,
            scaleX: 1,
            scaleY: 1,
            width: '',
            height: '',
            X: '',
            Y: ''
        },
     
        inputData: {
            width: $('#dataWidth-$uniqueId'),
            height: $('#dataHeight-$uniqueId'),
            X: $('#dataX-$uniqueId'),
            Y: $('#dataY-$uniqueId')
        }
    };
    
    var cropper_options_$uniqueId = {
        aspectRatio: $aspectRatio,
        viewMode: 2,            
        autoCropArea: 1,
        responsive: false,
        checkCrossOrigin: false,
        crop: function (e) {

            options_$uniqueId.data.width = Math.round(e.detail.width);
            options_$uniqueId.data.height = Math.round(e.detail.height);
            options_$uniqueId.data.X = e.detail.scaleX;
            options_$uniqueId.data.Y = e.detail.scaleY;      

            options_$uniqueId.inputData.width.val(Math.round(e.detail.width));
            options_$uniqueId.inputData.height.val(Math.round(e.detail.height));
            options_$uniqueId.inputData.X.val(Math.round(e.detail.x));
            options_$uniqueId.inputData.Y.val(Math.round(e.detail.y));                
            
            
            if (options_$uniqueId.data.width < options_$uniqueId.data.cropWidth) {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-success').addClass('has-error');
            } else {
                options_$uniqueId.element.modal.find('.width-warning').removeClass('has-error').addClass('has-success');
            }
            
            if (options_$uniqueId.data.height < options_$uniqueId.data.cropHeight) {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-success').addClass('has-error');                   
            } else {
                options_$uniqueId.element.modal.find('.height-warning').removeClass('has-error').addClass('has-success');                     
            }
        }, 
        
        ready: function () {            
            options_$uniqueId.croppable = true;
        }
    }
    
    
    // input file change
    options_$uniqueId.input.crop.change(function(event) {
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');        
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');        
        // image loading        
        if (typeof event.target.files[0] === 'undefined') {
            options_$uniqueId.element._image.src = "";
            return;
        }               
        options_$uniqueId.element._image.src = URL.createObjectURL(event.target.files[0]);                
        // cropper start
        options_$uniqueId.element.image.cropper(cropper_options_$uniqueId);        
    });
    
    
    
    
    var imageUrl_$uniqueId = '$imageUrl';
    var setElement_$uniqueId = function(src) {
        options_$uniqueId.element.modal.find('.modal-body > div').html('<img src="' + src + '" id="cropper-image-$uniqueId">');
        options_$uniqueId.element.image = $('#cropper-image-$uniqueId'); 
        options_$uniqueId.element._image = document.getElementById('cropper-image-$uniqueId');
    };    
    // if imageUrl is set    
    if (imageUrl_$uniqueId !== '') {
        setElement_$uniqueId(imageUrl_$uniqueId);        
    }
    // when set imageSrc directly from out 
    options_$uniqueId.input.urlChange.change(function(event) {        
        var _val = $(this).val();
        imageUrl_$uniqueId = _val;
        // cropper reset
        options_$uniqueId.croppable = false;
        options_$uniqueId.element.image.cropper('destroy');
        options_$uniqueId.element.modal.find('.width-warning, .height-warning').removeClass('has-success').removeClass('has-error');        
        if (!options_$uniqueId.element.modal.hasClass('in')) {
            setElement_$uniqueId(_val);
            options_$uniqueId.element.modal.modal('show'); 
        }
        
    });
    options_$uniqueId.element.modal.on('shown.bs.modal', function() {        
        if (imageUrl_$uniqueId !== '') {
            // cropper start
            options_$uniqueId.element.modal.find('.modal-body img').cropper(cropper_options_$uniqueId);
            imageUrl_$uniqueId = '';
        }       
    });
    
    
    function setCrop$uniqueId() {    
        options_$uniqueId.croppedCanvas = options_$uniqueId.element.image.cropper('getCroppedCanvas', {
            width: options_$uniqueId.data.cropWidth,
            height: options_$uniqueId.data.cropHeight
        });         
        img=options_$uniqueId.croppedCanvas.toDataURL();
        if("$uploadUrl"!=''){
            $.ajax({
                type: "$uploadMethod",
                url: "$uploadUrl",
                data:{
                    image:img
                }, 
                dataType: "json",
                success: function (res) {
                    options_$uniqueId.element.result.html('<img src="' + $uploadResponse + '" id="cropper-image-$uniqueId"  style="width:$previewWidth;height:$previewHeight;">');   
                    options_$uniqueId.input.model.attr('type', 'text');        
                    options_$uniqueId.input.model.val($uploadResponse);                    
                },
                complete:function(){
                }
            });
        }else{
            options_$uniqueId.element.result.html('<img src="' + img + '" id="cropper-image-$uniqueId"  style="width:$previewWidth;height:$previewHeight;">');   
            options_$uniqueId.input.model.attr('type', 'text');        
            options_$uniqueId.input.model.val(img);
        }
    }

    options_$uniqueId.button.crop.click(function() { 
        setCrop$uniqueId(); 
    });

    options_$uniqueId.button.close.click(function() { 
        options_$uniqueId.element.modal.modal('hide'); 
    });
  
    options_$uniqueId.button.delete.click(function() {
        options_$uniqueId.element.modal.modal('hide'); 
        options_$uniqueId.element.result.html('<img src="'+"$noImage"+'" id="cropper-image-$uniqueId" style="width: 128px; height: 128px;">');   
        options_$uniqueId.input.model.attr('type', 'text');        
        options_$uniqueId.input.model.val('');
    });
  

    $('[data-target="#cropper-modal-$uniqueId"]').click(function() {
        var src_$uniqueId = $('#cropper-modal-$uniqueId').find('.modal-body').find('img').attr('src');        
        if (src_$uniqueId === '') {
            options_$uniqueId.input.crop.click();
        }
    });

    
    

    options_$uniqueId.element.modal.find('.move-left').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', -10, 0);
    });
    options_$uniqueId.element.modal.find('.move-right').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 10, 0);     
    });
    options_$uniqueId.element.modal.find('.move-up').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, -10);      
    });
    options_$uniqueId.element.modal.find('.move-down').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('move', 0, 10);
    });
    options_$uniqueId.element.modal.find('.zoom-in').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', 0.1); 
    });
    options_$uniqueId.element.modal.find('.zoom-out').click(function() {
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('zoom', -0.1);         
    });
    options_$uniqueId.element.modal.find('.rotate-left').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', -15);
    });
    options_$uniqueId.element.modal.find('.rotate-right').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper('rotate', 15); 
    });
    options_$uniqueId.element.modal.find('.flip-horizontal').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleX = -1 * options_$uniqueId.data.scaleX;        
        options_$uniqueId.element.image.cropper('scaleX', options_$uniqueId.data.scaleX);
    });
    options_$uniqueId.element.modal.find('.reset').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper("reset"); 
    });
    options_$uniqueId.element.modal.find('.clear').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.element.image.cropper("clear"); 
    });
    options_$uniqueId.element.modal.find('.flip-vertical').click(function() { 
        if (!options_$uniqueId.croppable) return;
        options_$uniqueId.data.scaleY = -1 * options_$uniqueId.data.scaleY;
        options_$uniqueId.element.image.cropper('scaleY', options_$uniqueId.data.scaleY);
    });
    
JS
    , View::POS_END);

// on click crop or close button
if (isset($jsOptions['onClick'])) :
    $onClick = $jsOptions['onClick'];
    $script = <<<JS
        $('#crop-button-$uniqueId, #close-button-$uniqueId').click($onClick);
JS;
    $this->registerJs($script, View::POS_END);
endif;
?>
