<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
  use Authenticatable, Authorizable, CanResetPassword;

  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'social_provider_id','social_user_id','email','password','name','avatar','remember_token','user_key','jwt_secret_key','has_password','email_verified','online'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  private $path = 'app/public/users/';

  /**
    * Get the unique identifier for the user.
    *
    * @return mixed
    */
   public function getAuthIdentifier()
   {
       return $this->getKey();
   }

   /**
    * Get the token value for the "remember me" session.
    *
    * @return string
    */
   public function getRememberToken()
   {
       return $this->remember_token;
   }

   /**
    * Set the token value for the "remember me" session.
    *
    * @param  string  $value
    * @return void
    */
   public function setRememberToken($value)
   {
       $this->remember_token = $value;
   }

   /**
    * Get the column name for the "remember me" token.
    *
    * @return string
    */
   public function getRememberTokenName()
   {
       return 'remember_token';
   }

   /**
    * Get the e-mail address where password reminders are sent.
    *
    * @return string
    */
   public function getReminderEmail()
   {
       return $this->user_mail;
   }

   /**
    * Get the password for the user.
    *
    * @return string
    */
   public function getAuthPassword()
   {
       return $this->user_password;
   }

   public function getAvartarPath() {
    return storage_path($this->path.$this->id.'/avatar/');
   }

   public function getAvartarImage($avatar = '') {

     if(empty($avatar)) {
       $avatar = $this->avatar;
     }

     return $this->getAvartarPath().$avatar;
   }
}
