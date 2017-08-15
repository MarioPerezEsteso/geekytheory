<?php

namespace app\Transformers;

use App\User;

class UserTransformer extends BaseTransformer
{
    /**
     * Turn this item object into a generic array.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        $data = $user->toArray();
        $data = self::arrayToCamelCase($data);

        return $data;
    }
}