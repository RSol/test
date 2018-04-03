<?php

namespace app\widgets;


use app\models\NewsSearch;
use yii\base\Widget;

class News extends Widget
{
    /**
     * @var int Default page size
     */
    public $pageSize = 10;

    /**
     * @var string Page param for GET and session store
     */
    public $pageParam = 'newsPageSize';

    /**
     * @var array Available page sizes list
     */
    public $pageSizesSet = [
        2, 5, 10, 20, 30
    ];

    public function run()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search([
            'status' => \app\models\News::STATUS_ACTIVE,
        ]);

        $dataProvider->pagination->pageSize = $this->getPageSize();

        return $this->render('news', [
            'dataProvider' => $dataProvider,
            'pageSizesSet' => array_combine($this->pageSizesSet, $this->pageSizesSet),
            'pageParam' => $this->pageParam
        ]);
    }

    /**
     * @return integer
     */
    private function getPageSize()
    {
        if ($pageSize = \Yii::$app->request->get($this->pageParam)) {
            \Yii::$app->session->set($this->pageParam, $pageSize);
        } else {
            $pageSize = \Yii::$app->session->get($this->pageParam, $this->pageSize);
        }
        return intval($pageSize) ? $pageSize : $this->pageParam;
    }
}