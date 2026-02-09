<?php

namespace App\Models;

use App\Enums\SubscriptionType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasUlids;

    /**
     * The attributes that are mass protecable.
     *
     * @var list<string>, String
     */
    protected $guarded = ['id'];
    protected $keyType = 'string';

    /**
     * The attributes that are mass public.
     *
     * @var String
     */
    public $incrementing = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subscription_type' => SubscriptionType::class,
            'valid_from' => 'datetime',
            'valid_to'   => 'datetime',
        ];
    }

    /**
     * Relation Model
     * 
     * 
     */
    public function users() {
        return $this->belongsToMany(
            User::class, 
            'subscription_user', 
            'subscription_id', 
            'user_id'
        )->withTimestamps();
    }
    public function outlets() {
        return $this->belongsToMany(
            Outlet::class, 
            'outlet_subscription', 
            'subscription_id', 
            'outlet_id'
        )->withTimestamps();
    }

    /**
     * Pemeriksaan subscription status active/expired.
     * 
     * @param mixed $query
     * @return query
     */
    public function scopeActive($query)
    {
        $now = now();

        return $query->where('subscription_status', 'active')
                    ->where('valid_from', '<=', $now)
                    ->where('valid_to', '>=', $now);
    }

    /**
     * Mencari pemilik subscription.
     * 
     * @param mixed $query
     * @param User $user
     * @return query
     */
    public function scopeOwnedBy($query, String $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    /**
     * Pemeriksaan subscription status active/expired.
     * 
     * @param mixed $query
     * @param string $outletId
     * @return query
     */
    public function scopeForOutletJoin($query, string $outletId)
    {
        return $query->join(
            'outlet_subscription',
            'subscriptions.id',
            '=',
            'outlet_subscription.subscription_id'
        )->where('outlet_subscription.outlet_id', $outletId);
    }

    /**
     * Resolve subscription id owned by owner for specific outlet
     * 
     * @param User $owner
     * @param string $outletId
     * @return string
     */
    public static function resolveIdByOwnerAndOutlet(
        string $ownerId, 
        string $outletId
    ): string{
        $subscriptionId = static::ownedBy($ownerId)
            ->forOutletJoin($outletId)
            ->value('subscriptions.id');

        throw_if(!$subscriptionId, ModelNotFoundException::class);

        return $subscriptionId;
    }
}
