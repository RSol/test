<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $status
 * @property string $created_at
 *
 * @property User $user
 */
class News extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            [
                'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                'attribute' => 'image',
                'thumbs' => [
                    'thumb' => ['width' => 200, 'height' => 200],
                ],
                'filePath' => '@webroot/images/news/[[pk]].[[extension]]',
                'fileUrl' => '/images/news/[[pk]].[[extension]]',
                'thumbPath' => '@webroot/images/news/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '/images/news/[[profile]]_[[pk]].[[extension]]',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['user_id'], 'default', 'value' => Yii::$app->user->id],
            [['status'], 'default', 'value' => static::STATUS_ACTIVE],
            [['created_at'], 'default', 'value' => new Expression('NOW()')],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['image', 'file', 'extensions' => 'jpeg, jpg, gif, png'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('news', 'ID'),
            'user_id' => Yii::t('news', 'User ID'),
            'title' => Yii::t('news', 'Title'),
            'description' => Yii::t('news', 'Description'),
            'image' => Yii::t('news', 'Image'),
            'status' => Yii::t('news', 'Status'),
            'created_at' => Yii::t('news', 'Created At'),
        ];
    }

    /**
     * Just for just
     * {@inheritdoc}
     */
//    public function beforeSave($insert)
//    {
//        if ($insert) {
//            $this->user_id = Yii::$app->user->id;
//            $this->created_at = new Expression('NOW()');
//        }
//        return parent::beforeSave($insert);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * List of statuses
     * @return array
     */
    public static function getStatusList()
    {
        return [
            static::STATUS_ACTIVE => Yii::t('news', 'Active'),
            static::STATUS_DISABLED => Yii::t('news', 'Disabled'),
        ];
    }

    /**
     * Return status label
     * @return string
     */
    public function getStatusLabel()
    {
        $statuses = static::getStatusList();
        return ArrayHelper::getValue($statuses, $this->status);
    }
}
