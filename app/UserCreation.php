<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCreation extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_creations';

    protected $guarded = ['id'];

    /**
     * Find by uuid, or throw an exception.
     *
     * @param string $username The username.
     * @param mixed $columns The columns to return.
     *
     * @throws ModelNotFoundException if no matching User exists.
     *
     * @return User
     */
    public static function findByTransactionIdOrFail(
        $tid,
        $columns = array('*')
    ) {
        if ( ! is_null($user = static::where('transaction_id', $tid )->first($columns))) {
            return $user;
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
    }

}
