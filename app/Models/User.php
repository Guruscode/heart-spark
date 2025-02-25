<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Message;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'phone', 'age', 'gender', 'location', 'bio', 'interests', 'profile_picture' ,   'password',
        'subscription_type', 'subscription', 'paid', 
        'subscription_started_at', 'subscription_expires_at', 'payment_provider', 'payment_reference'
    ];

    protected $dates = ['subscription_started_at', 'subscription_expires_at'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      // Check if user has an active subscription
      public function hasActiveSubscription()
      {
          return $this->subscription && $this->subscription_expires_at && $this->subscription_expires_at->isFuture();
      }
  
      // Check if user is subscribed to premium
      public function isPremium()
      {
          return $this->subscription_type === 'premium' && $this->hasActiveSubscription();
      }
  
      // Check if subscription has expired
      public function hasExpiredSubscription()
      {
          return $this->subscription_expires_at && $this->subscription_expires_at->isPast();
      }
    public function likes()
{
    return $this->hasMany(Like::class, 'liked_user_id', 'id');
}

public function sentMessages() {
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages() {
    return $this->hasMany(Message::class, 'receiver_id');
}

public function notifications() {
    return $this->hasMany(Notification::class);
}

}
