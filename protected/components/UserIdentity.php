<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	/**
	 * Authenticates a user against the user database.
     * If the authentication was successful, a 'roles'
     * state will be attached to this class instance
     * which contains all of the roles for the current user.
     *
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username = strtolower($this->username);
		$user = User::model()->find("LOWER(username)=?", array($username));

		if ($user === null) 
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif (!$user->validatePassword($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->errorCode = self::ERROR_NONE;
			
			$roles = array();
			foreach($user->getRoleNames() as $role)
				$roles[strtolower($role)] = true;
			$this->setState('roles', $roles);
			$this->username = $user->username;
		}

		return $this->errorCode == self::ERROR_NONE;
	}
}