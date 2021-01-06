<?php


namespace App\Transformers;


use App\Models\AbstractModel;
use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{
    public function change(AbstractModel $model, array $information)
    {
        $startTransform = ['id' => $model->getId()];
        $endTransform   = [
            'createdAt' => $model->getCreatedAt()->toDateTimeString(),
            'updatedAt' => $model->getUpdatedAtAt()->toDateTimeString()
        ];
        return array_merge($startTransform, $information, $endTransform);
    }
}
