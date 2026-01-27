<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass protecable.
     *
     * @var list<string>, String
     */
    protected $keyType = 'string';
    # The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'username',
        'email',
        'msisdn',
        'password',
        'is_active',
    ];
    # The attributes that should be hidden for serialization.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass public.
     *
     * @var Boolean
     */
    public $incrementing = false;

    /**
     * Fungsi ketika model Eloquent selesai dimuat.
     *
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation Model
     * 
     */
    public function roles() {
        return $this->belongsToMany(
            Role::class, 
            'role_user', 
            'user_id', 
            'role_id'
        )->withTimestamps();
    }
    public function subscriptions() {
        return $this->belongsToMany(
            Subscription::class, 
            'subscription_user', 
            'user_id', 
            'subscription_id'
        )->withTimestamps();
    }
    # Relasi tabel outlets jika user adalah owner
    public function ownedOutlets() {
        return $this->hasMany(Outlet::class, 'owner_id');
    }
    # Relasi tabel outlets jika user adalah karyawan
    public function outlets()
    {
        return $this->belongsToMany(
            Outlet::class,
            'outlet_user',
            'user_id',
            'outlet_id'
        )->using(OutletUser::class)->withPivot('role_id')->withTimestamps();
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Menggunakan ID pengguna (primary key)
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Anda bisa menambahkan role, dsb. di sini
    }

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
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Pemeriksaan izin tertentu role penguna.
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = $this->loadMissing('roles.permissions')
            ->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('slug');

        if ($permissions->contains('*')) {
            return true;
        }

        if ($permissions->contains($permission)) {
            return true;
        }

        return $permissions->contains(fn ($slug) =>
            Str::is($slug, $permission)
        );
    }

    /**
     * Pemeriksaan subscription status active/expired.
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Pemeriksaan status subscription user ada/active/expired.
     * 
     * @return bool
     */
    public function hasValidSubscription(): bool 
    {
        return $this->subscriptions()->active()->exists();
    }

    /**
     * Pemeriksaan user ada/punya outlet.
     * 
     * @return bool
     */
    public function hasValidOutlet(): bool 
    {
        return $this->outlets()
            ->whereHas('subscriptions', fn ($q) => $q->active())->exists();
    }

    /**
     * Pemeriksaan user ada/punya outlet.
     * 
     * @param stirng $ownerId
     * @param array $outletId
     * @return void
     */
    public function assignSubscriptionByOutlet(
        string $ownerId, 
        array $outletIds
    ): void{
        foreach ($outletIds as $outletId) {
            # code...
            $subscriptionId = Subscription::resolveIdByOwnerAndOutlet(
                ownerId: (string) $ownerId,
                outletId: (string) $outletId
            );
    
            $this->subscriptions()->sync($subscriptionId);
        }
    }
}
