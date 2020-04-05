<?php

namespace app\controllers;

use app\models\BuyForm;
use app\models\CinemaPlaces;
use app\models\Film;
use app\models\Seance;
use app\modules\backend\models\search\FilmSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * {@inheritdoc}
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
        $searchModel = new FilmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        $popular_films = Film::find()->active()->orderBy('popularity_rating DESC')->limit(5)->all();

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'popular_films' => $popular_films
            ]);
    }

    /**
     *  View action.
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug){
        $model = Film::find()->active()->where(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException('Page not found');
        }

        return $this->render('view', ['model' => $model]);
    }

    /**
     *  Seance action.
     * @param $slug
     * @param $film
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSeance($slug, $film){
        $seance = Seance::find()->where(['slug' => $slug])->one();
        $film = Film::findOne($film);
        if (!$seance) {
            throw new NotFoundHttpException('Page not found');
        }
        $buy_form = new BuyForm();
        if (Yii::$app->request->isAjax){
            if ($buy_form->load(Yii::$app->request->post()) && $buy_form->validate()) {

                foreach($buy_form['array_tickets'] as $key => $val){
                    $seance->cinema_places_ar[$val] = CinemaPlaces::PLACE_SOLD;
                }
                $film->popularity_rating += count($buy_form->array_tickets);
                if( $film->save() && $seance->save()){
                    return $buy_form['name']." congratulations to you! You bought ". count($buy_form['array_tickets']) ." place!" ;
                }
            }
        }


        return $this->render('view_buy', ['seance' => $seance, 'film' => $film ,'buy_form' => $buy_form]);
    }

    /**
     * Login action.
     *
     * @return Response|string
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
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
}
