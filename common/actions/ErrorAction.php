<?php

namespace common\actions;

use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\NotFoundHttpException;
use common\modules\file\filestorage\Instance;
use common\modules\file\helpers\FileHelper;
use common\modules\file\helpers\StyleHelper;
use yii\web\ErrorAction as ErrorActionBase;


class ErrorAction extends ErrorActionBase
{


    /**
     * Runs the action.
     *
     * @return string result content
     */
    public function run()
    {


        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }

        Yii::$app->getResponse()->setStatusCodeByException($this->exception);

        if (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjaxResponse();
        }

        return $this->renderHtmlResponse();
    }



    /** @inheritdoc */
    public function run2()
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } elseif($exception instanceof NotFoundHttpException
                && ($style = new StyleHelper(Yii::$app->request->url)) 
                && $style->validate()){
                $file = Instance::findOne($style->getFileId());
                $url = FileHelper::createPreview($file, $style);

                if($url){
                    header("Content-type: ".$file->mimetype);
                    header ("Accept-Ranges: bytes");
                    header ("Content-Length: ".filesize($url));  
                    readfile($url);
                }  
        } else {
            return $this->controller->render($this->view ?: $this->id, [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}
