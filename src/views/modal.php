<?php
/**
 *
 * this html text must be 1 line for javascript content
 *
 */
/** @var $unique string */
/** @var $cropperOptions [] */
/** @var $modalOptions [] */

$modalLabel = $modalOptions['title'] ?? Yii::t('cropper', 'Image Crop Editor');
$browseLabel = $cropperOptions['icons']['browse'] . ' ' . ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Browse'));
$cropLabel = $cropperOptions['icons']['crop'] . ' ' . ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Crop'));
$closeLabel = $cropperOptions['icons']['close'] . ' ' .  ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Close'));

$cropWidth = $cropperOptions['width'];
$cropHeight = $cropperOptions['height'];

$cropReset=$cropperOptions['icons']['reset'] . ' ' .  ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Reset'));
$cropDelete = $cropperOptions['icons']['delete'] . ' ' .  ($modalOptions['labels']['crop'] ?? Yii::t('cropper', 'Delete'));


echo '<div class="modal fade" tabindex="-1" role="dialog" id="cropper-modal-'. $unique .'">'
    .'<div class="modal-dialog modal-lg" role="document">'
        .'<div class="modal-content">'
            .'<div class="modal-header">'
                .'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                .'<h4 class="modal-title" id="modalLabel-'. $unique .'">'. $modalLabel .'</h4>'
            .'</div>'
            .'<div class="modal-body">'
                .'<div><img id="cropper-image-'. $unique .'" src="" alt=""></div>'
            .'</div>'
            .'<div class="modal-footer">'
                .'<div class="row" style="margin-bottom: 10px;'.($modalOptions['tips']===false?'display:none;':'').'">'
                    .'<div class="col-xs-12 text-left">'
                        .'<div class="alert alert-warning alert-dismissible">'
                            .'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                            .Yii::t('cropper', 'Double click: toggle between "move image" or "redraw area"')
                        .'</div>'
                    .'</div>'
                    .'<div class="col-xs-12 text-left" style="margin-bottom: 10px;'.($modalOptions['extendInfo']===false?'display:none;':'').'">'
                        .'<div class="col-sm-3">'
                            .'<div class="input-group input-group-sm width-warning">'
                                .'<label class="input-group-addon" for="dataWidth-'. $unique .'">'.Yii::t('cropper', 'Width').' ('. $cropWidth .'px)</label>'
                                .'<input type="text" class="form-control" id="dataWidth-'. $unique .'" placeholder="width"><span class="input-group-addon">px</span>'
                            .'</div>'
                        .'</div>'
                        .'<div class="col-sm-3">'
                            .'<div class="input-group input-group-sm height-warning">'
                                .'<label class="input-group-addon" for="dataHeight-'. $unique .'">'.Yii::t('cropper', 'Height') .' ('. $cropHeight .'px)</label>'
                                .'<input type="text" class="form-control" id="dataHeight-'. $unique .'" placeholder="height"><span class="input-group-addon">px</span>'
                            .'</div>'
                        .'</div>'
                        .'<div class="col-sm-3">'
                            .'<div class="input-group input-group-sm">'
                                .'<label class="input-group-addon" for="dataX-'. $unique .'">X</label>'
                                .'<input type="text" class="form-control" id="dataX-'. $unique .'" placeholder="x"><span class="input-group-addon">px</span>'
                            .'</div>'
                        .'</div>'
                        .'<div class="col-sm-3">'
                            .'<div class="input-group input-group-sm">'
                                .'<label class="input-group-addon" for="dataY-'. $unique .'">Y</label>'
                                .'<input type="text" class="form-control" id="dataY-'. $unique .'" placeholder="y"><span class="input-group-addon">px</span>'
                            .'</div>'
                        .'</div>'
                    .'</div>'
                .'</div>'
                .'<div class="pull-left">'
                    .'<span class="btn btn-primary btn-file">'. $browseLabel
                        .'<input type="file" id="cropper-input-'. $unique .'" title="'. Yii::t('cropper', 'Browse') .'" accept="image/*">'
                    .'</span>&nbsp;'
                    .'<div class="btn-group">'
                        .($cropperOptions['icons']['zoom-in'] !== false ? '<button type="button" class="btn btn-primary zoom-in">'.$cropperOptions['icons']['zoom-in'].'</span></button>' : null)
                        .($cropperOptions['icons']['zoom-out'] !== false ? '<button type="button" class="btn btn-primary zoom-out">'.$cropperOptions['icons']['zoom-out'].'</button>' : null)
                    .'</div>&nbsp;'
                    .'<div class="btn-group">'
                        .($cropperOptions['icons']['rotate-left'] !== false ? '<button type="button" class="btn btn-primary rotate-left">'.$cropperOptions['icons']['rotate-left'].'</button>' : null)
                        .($cropperOptions['icons']['rotate-right'] !== false ? '<button type="button" class="btn btn-primary rotate-right">'.$cropperOptions['icons']['rotate-right'].'</button>' : null)
                        .($cropperOptions['icons']['flip-horizontal'] !== false ? '<button type="button" class="btn btn-primary flip-horizontal">'.$cropperOptions['icons']['flip-horizontal'].'</button>' : null)
                        .($cropperOptions['icons']['flip-vertical'] !== false ? '<button type="button" class="btn btn-primary flip-vertical">'.$cropperOptions['icons']['flip-vertical'].'</button>' : null)
                    .'</div>&nbsp;'
                    .'<div class="btn-group">'
                        .($cropperOptions['icons']['move-left'] !== false ? '<button type="button" class="btn btn-primary move-left">'.$cropperOptions['icons']['move-left'].'</button>' : null)
                        .($cropperOptions['icons']['move-right'] !== false ? '<button type="button" class="btn btn-primary move-right">'.$cropperOptions['icons']['move-right'].'</span></button>' : null)
                        .($cropperOptions['icons']['move-up'] !== false ? '<button type="button" class="btn btn-primary move-up">'.$cropperOptions['icons']['move-up'].'</button>' : null)
                        .($cropperOptions['icons']['move-down'] !== false ? '<button type="button" class="btn btn-primary move-down">'.$cropperOptions['icons']['move-down'].'</button>' : null)
                    .'</div>'                   
                .'</div>'
                .($cropperOptions['icons']['reset'] !== false ? '<button type="button" class="btn btn-info reset" id="reset-button-'. $unique .'">'.$cropReset.'</button>' : null)
                .($cropperOptions['icons']['delete'] !== false ? '<button type="button" class="btn btn-warning delete" id="delete-button-'. $unique .'">'.$cropDelete.'</button>' : null)
                .($cropperOptions['icons']['close'] !== false ? '<button type="button"  class="btn btn-success" data-dismiss="modal">'. $closeLabel .'</button>' : null)
                .'<button type="button" id="crop-button-'. $unique .'" class="btn btn-danger" data-dismiss="modal">'. $cropLabel .'</button>'
            .'</div>'
        .'</div>'
    .'</div>'
.'</div>';
