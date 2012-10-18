<?php
/**
 * AppUser class file
 *
 * @author Jason Larke
 * @date 19/08/2012
 */

/**
 * The AppUser class is the session-based web user component for the application.
 * It extends the functionality of the Yii "CWebUser" to allow for a role-based 
 * application user. Each role is stored as an array key in the component's "roles"
 * state. Each key is associated with a boolean true/false value (in this component
 * the boolean is never set to false, but may be an option in the future)
*/
class AppUser extends CWebUser
{
	public $loginUrl = array('/site/login');

	/**
	 * void addRoles(array $roles)
	 * Adds roles to the current instance of the application user.
	 * @param $roles string array containing the names of all the roles to add to the user.
	 */
	public function addRoles($roles=array())
	{
		if (!$this->hasState('roles')) //check to see if the 'roles' state has already been set, and if not initialize it.
			$this->setState('roles', array());
	
		if ($roles !== null)
			foreach($roles as $role)
				$this->roles[strtolower($role)] = true;
	}
	
	/**
	 * boolean hasRoles(array $roles)
	 * Checks the current user to verify whether they have all the roles specified in the $roles parameter
	 * see also "hasAnyRoles" for alternate role checking.
	 * @param $roles string array containing the names of all the roles to validate
	 * @return true if the user has all the roles specified in $roles, false if $roles is null or not an array, or the user doesn't have all the specified roles
	 */
	public function hasRoles($roles=array())
	{
		if ($roles !== null && $this->hasState('roles'))
		{
			$roles = (array)$roles; // sanitize.
				
			foreach($roles as $role)
				if (!isset($this->roles[strtolower($role)]) || !$this->roles[strtolower($role)])
					return false;
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * boolean hasAnyRoles(array $roles)
	 * Checks whether the current user has any of the roles specified in the $roles parameter
	 * Useful when checking shared pages which multiple different roles can access.
	 * @param $roles string array cotnaining the names of the roles to check against
	 * @return true if the user has any of the roles in the $roles parameter. false if the user has none of the roles, or $roles is null.
	 */
	public function hasAnyRoles($roles=array())
	{
		if ($roles !== null && $this->hasState('roles'))
		{
			$roles = (array)$roles; //sanitize the input
				
			foreach($roles as $role)
				if (isset($this->roles[strtolower($role)]) && $this->roles[strtolower($role)])
					return true;
			return false;
		}
		else
		{
			return false;
		}
	}
}
?>