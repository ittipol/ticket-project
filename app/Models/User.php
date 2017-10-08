<?php

namespace App\Models;

class User extends Model
{
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'social_provider_id','social_user_id','email','password','name','avatar','remember_token','user_key','has_password','email_verified'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];
}
