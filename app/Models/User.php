<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Redis;
use App\library\date;

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
      'social_provider_id',
      'social_user_id',
      'email',
      'password',
      'name',
      'avatar',
      'remember_token',
      'user_key',
      'jwt_secret_key',
      'has_password',
      'email_verified',
      'online',
      'last_active'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  private $path = 'app/public/images/user/';

  public $imageTypeAllowed = array(
    'avatar' => array(
      'limit' => 1
    )
  );

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

  public function getProfileImage() {

   $image = Image::select('id','model','model_id','filename','image_type_id')->find($this->avatar);

   if(empty($image)) {
     return array();
   }

   return array(
     'id' => $image->id,
     '_url' => $image->getImageUrl()
   );
  }

  // public function buildDataDetail() {
  //   return array(
  //     'id' => $this->id,
  //     'name' => $this->name,
  //     'avatar' => $this->avatar,
  //     'online' => $this->online,
  //     'last_active' => Date::calPassedDate($this->last_active)
  //   );
  // }

  public static function buildProfile($id) {
    $user = User::select('name')->find($id);

    if(empty($user)) {
      return null;
    }

    return array(
      'id' => $id,
      'name' => $user->name,
      // 'avatar' => $user->avatar,
      'online' => Redis::get('user-online:'.$id)
    );

  }

  public static function buildProfileForTicketList($id) {
    $user = User::select('name')->find($id);

    if(empty($user)) {
      return null;
    }

    return array(
      'name' => $user->name,
      'online' => Redis::get('user-online:'.$id)
    );
  }

  public static function buildProfileForTicketDetail($id) {
    $user = User::select('name','avatar','last_active')->find($id);

    if(empty($user)) {
      return null;
    }

    return array(
      'name' => $user->name,
      // 'avatar' => $user->avatar,
      'last_active' => Date::calPassedDate($user->last_active),
      'online' => Redis::get('user-online:'.$id)
    );

  }

}
