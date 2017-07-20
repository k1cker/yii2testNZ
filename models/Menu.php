<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property string $name
 * @property string $link
 */
class Menu extends \yii\db\ActiveRecord
{

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                 'leftAttribute' => 'lft',
                 'rightAttribute' => 'rgt',
                 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link','name'],'required'],
            [['tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['name','link'], 'string', 'max' => 255],
            ['link', 'match', 'pattern' => '/(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', 'message' => 'Your url is incorrect. Must be site.com or http://site.com or https://site.com'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'name' => Yii::t('app', 'Name'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public function getParentId()
    {
        $parent = $this->parent;
        return $parent ? $parent->id : null;
    }

    /**
     * Get parent's node
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->parents(1)->one();
    }

    /**
     * Get a full tree as a list, except the node and its children
     * @param  integer $node_id node's ID
     * @return array array of node
     */


    /**
     * Get menu roots
     * @return mixed
     */
    public static function getRoots()
    {
        return Menu::find()->where('id <>1')->roots()->all();
    }

    /**
     * Get children by first level for the current node
     * @param Menu $node
     * @return mixed
     */
    public static function getChildren($node)
    {
        return $node->children(1)->all();
    }

    public static function getTree($node_id = 0)
    {

        $children = [];

        if (!empty($node_id))
            $children = array_merge(
                self::findOne($node_id)->children()->column(),
                [$node_id]
            );

        $rows = self::find()->
        select('id, name,depth')->
        where(['NOT IN','id',$children])->
        orderBy('tree, lft')->
        all();

        $return = [];
        foreach ($rows as $row)
            $return[$row->id] = str_repeat('-', $row->depth) . ' ' . $row->name;

        return $return;
    }

    /**
     * Get type of menu
     * @return array
     */


    /**
     * Get multidimensional menu
     * @param null|array $nodes
     * @return array
     */
    public static function getMenu($nodes = null)
    {

        $nodes = (is_null($nodes)) ? Menu::getRoots() : $nodes;
        $menu = [];
        foreach ($nodes as $node) {

            if (!preg_match('/(http|https):\/\//', $node->link)) {
                $node->link = 'http://'.$node->link;
            }
            $newRecord = [
                "label" => $node['name'],
                "url" => (($node['link']) ? $node['link'] : '#'),
            ];

            if (!empty($children = Menu::getChildren($node))) {
                $newRecord['items'] = Menu::getMenu($children);

            }

            $menu[] = $newRecord;

        }

        return $menu;
    }


}
