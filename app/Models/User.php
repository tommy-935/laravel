<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    static $_table = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userRoles()
    {
        return $this->hasMany(UserRoles::class, 'user_id', 'id');
    }

    public static function getList(Array $where = [], Int $limit = 10){
        $query = DB::table(self::$_table . ' as a');
        $data = $query->select('a.*', 'b.role_id', 'c.name as role_name')
            ->leftjoin('user_role as b', 'a.id', '=', 'b.user_id')
            ->leftjoin('role as c', 'b.role_id', '=', 'c.id')
            ->where($where)
           // ->limit($limit)
            ->orderBy('a.id', 'desc')
            ->paginate($limit);
        // $sql = vsprintf(str_replace('?', "'%s'", $query->toSql()), $query->getBindings());
        // error_log(print_r($sql, true) . "\r\n", 3, 'e:/www/debug.log');
        return $data;
    }
}
