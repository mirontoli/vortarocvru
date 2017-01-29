<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EditForm;
use app\models\SearchForm;
use app\models\Chuvash;
use app\models\Russian;
use app\models\Transcription;
use app\models\Chv2rus;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'edit'],
                'rules' => [
                    [
                        'actions' => ['logout', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new SearchForm();

        $result = [];
        $str = '';
        $lang= 1;

        if(Yii::$app->request->post()) {
            if(Yii::$app->request->post('SearchForm')['term'] && Yii::$app->request->post('SearchForm')['lang']) {
                $str = Yii::$app->request->post('SearchForm')['term'];
                $lang = Yii::$app->request->post('SearchForm')['lang'];

                $result = (new \yii\db\Query())
                ->select('c.id as fid, c.term as fterm, r.id as lid, r.term as lterm')
                /*
                    switch(Yii::$app->request->post('SearchForm')['lang']) {
                        case 1: $result = $result->select('c.id as fid, c.term as fterm, r.id as lid, r.term as lterm'); break;
                        case 2: $result = $result->select('c.id as lid, c.term as lterm, r.id as fid, r.term as fterm'); break;
                        default: $result = $result->select('c.id as fid, c.term as fterm, r.id as lid, r.term as lterm'); break;
                    }
                */
                ->addSelect(['transcription' => 't.value', 'examples' => 'c2r.examples'])
                ->from('chv2ru c2r')
                ->innerjoin('chuvash c', 'c.id=c2r.chv_id')
                ->innerjoin('russian r', 'r.id=c2r.rus_id')
                ->innerjoin('transcription t', 't.chv_id=c.id');
                    switch(Yii::$app->request->post('SearchForm')['lang']) {
                        case 1: $result = $result->where(['like', 'c.term', Yii::$app->request->post('SearchForm')['term']]); break;
                        case 2: $result = $result->where(['like', 'r.term', Yii::$app->request->post('SearchForm')['term']]); break;
                        default: $result = $result->where(['like', 'c.term', Yii::$app->request->post('SearchForm')['term']]); break;
                    }
                $result = $result->all();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'result' => $result,
            'str' => $str,
            'lang' => $lang,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEdit()
    {
        $model = new EditForm(); 

        // если id не заданы, создаем новую запись
        if(!Yii::$app->request->get('id1') && !Yii::$app->request->get('id2')) {

            if ($model->load(Yii::$app->request->post())) {
                $chuvash = new Chuvash();
                $chuvash->term = $model->chvterm;
                $chuvash->save();

                $russian = new Russian();
                $russian->term = $model->rusterm;
                $russian->save();

                $cv2ru = new Chv2rus();
                $cv2ru->chv_id = $chuvash->id;
                $cv2ru->rus_id = $russian->id;
                $cv2ru->examples = $model->examples;
                $cv2ru->save();

                $transcription = new Transcription();
                $transcription->value = $model->transcription;
                $transcription->chv_id = $chuvash->id;
                $transcription->save();

                return $this->goHome();

            }

        } // иначе, достаем данные по id
          else {
            $cvt = Chuvash::findOne(Yii::$app->request->get('id1'));
            $model->chvterm = $cvt->term;

            $rut = Russian::findOne(Yii::$app->request->get('id2'));
            $model->rusterm = $rut->term;

            $exm = Chv2rus::find()->where('chv_id=:id1 and rus_id=:id2', [':id1' => Yii::$app->request->get('id1'), ':id2' => Yii::$app->request->get('id2')])->one();;
            $model->examples = $exm->examples;

            $trn = Transcription::find()->where('chv_id=:id1', [':id1' => Yii::$app->request->get('id1')])->one();
            $model->transcription = $trn->value;

            if ($model->load(Yii::$app->request->post())) {
                if($cvt->term != $model->chvterm) {
                    $cvt->term = $model->chvterm;
                    $cvt->save();
                }
                if($rut->term != $model->rusterm) {
                    $rut->term = $model->rusterm;
                    $rut->save();
                }
                if($exm->examples != $model->examples) {
                    $exm->examples = $model->examples;
                    $exm->save();
                }
                if($trn->value != $model->transcription) {
                    $trn->value = $model->transcription;
                    $trn->save();
                }

                return $this->goHome();
            }

        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }
}
