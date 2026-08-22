<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /** Un seul point de verite pour la question "ce compte est-il administrateur ?". */
    public function estAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /** Les humeurs enregistrees par cet etudiant. */
    public function moods()
    {
        return $this->hasMany(Mood::class);
    }

    /** Ses echanges avec WellBot. */
    public function chatbotMessages()
    {
        return $this->hasMany(ChatbotMessage::class);
    }
}
