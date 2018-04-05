<?php

namespace backend\widgets\grid;

use store\access\Rbac;
use Yii;
use yii\grid\DataColumn;
use yii\rbac\Item;
use yii\helpers\Html;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        $roles = Yii::$app->authManager->getRolesByUser($model->id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role){
            return $this->getRoleLabel($role);
        }, $roles));
    }

    private function getRoleLabel(Item $role): string
    {
        $class = $role->name == Rbac::ROLE_USER ? 'primary' : 'success';
        return Html::tag('span', Html::encode($role->name), ['class' => 'label label-'. $class]);
    }
}