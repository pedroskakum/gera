<?php
/** @package    Gera::Model */

/** import supporting libraries */
require_once("DAO/UsuarioDAO.php");
require_once("UsuarioCriteria.php");

/**
 * The Usuario class extends UsuarioDAO which provides the access
 * to the datastore.
 *
 * @package Gera::Model
 * @author ClassBuilder
 * @version 1.0
 */
class Usuario extends UsuarioDAO implements IAuthenticatable
{

    static $PERMISSION_READ = 1;
    static $PERMISSION_WRITE = 2;
    static $PERMISSION_EDIT = 4;
    static $PERMISSION_ADMIN = 8;

    /**
     * {@inheritdoc}
     */
    public function IsAnonymous()
    {
        // ANY ACCOUNT THAT WAS LOADED FROM THE DB IS NOT CONSIDERED TO BE AN ANONYMOUS USER
        return $this->IsLoaded();
    }

    /**
     * {@inheritdoc}
     */
    public function IsAuthorized($permission)
    {
        // THIS COULD BE MADE MORE EFFICIENT BY CACHING THE ROLE VARIABLE
        // OR JUST HARD-CODING ROLE NAMES AND PERMISSIONS SO YOU DON'T
        // HAVE TO DO A DATABASE LOOKUP ON THE ROLE TABLE EVERY TIME

        // GET THE ROLE FOR THIS USER
        $role = $this->GetRole();

        // IF THE PERMISSION BEING REQUESTED IS SOMETHING THAT THIS USER'S ROLE HAS, THEN THEY ARE AUTHORIZED
        if ($permission == self::$PERMISSION_READ && $role->CanRead) return true;
        if ($permission == self::$PERMISSION_WRITE && $role->CanWrite) return true;
        if ($permission == self::$PERMISSION_EDIT && $role->CanEdit) return true;
        if ($permission == self::$PERMISSION_ADMIN && $role->CanAdmin) return true;

        // IF THERE WERE NO MATCHES THEN THAT MEANS THIS USER DOESNT' HAVE THE REQUESTED PERMISSION
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function Login($username,$password)
    {
        // IF THERE IS NO USERNAME THEN DON'T BOTHER CHECKING THE DATABASE
        if (!$username) return false;

        $result = false;

        $criteria = new UsuarioCriteria();
        $criteria->Username_Equals = $username;

        try {
            $user = $this->_phreezer->GetByCriteria("Usuario", $criteria);

            // WE NEED TO STRIP OFF THE "!!!" PREFIX THAT WAS ADDED IN "OnSave" BELOW:
            $hash = substr($user->Password, 3);

            if (password_verify($password, $hash))
            {
                // THE USERNAME/PASSWORD COMBO IS CORRECT!

                // WHAT THIS IS DOING IS BASICALLY CLONING THE USER RESULT
                // FROM THE DATABASE INTO THE CURRENT RECORD.
                $this->LoadFromObject($user);

                $result = true;
            }
            else
            {
                // THE USERNAME WAS FOUND BUT THE PASSWORD DIDN'T MATCH
                $result = false;
            }

        }
        catch (NotFoundException $nfex) {

            // NO ACCOUNT WAS FOUND WITH THE GIVEN USERNAME
            $result = false;
        }

        return $result;
    }

	/**
	 * Override default validation
	 * @see Phreezable::Validate()
	 */
	public function Validate()
	{
		// example of custom validation
		// $this->ResetValidationErrors();
		// $errors = $this->GetValidationErrors();
		// if ($error == true) $this->AddValidationError('FieldName', 'Error Information');
		// return !$this->HasValidationErrors();

		return parent::Validate();
	}

	/**
	 * @see Phreezable::OnSave()
	 */
	public function OnSave($insert)
	{
		// the controller create/update methods validate before saving.  this will be a
		// redundant validation check, however it will ensure data integrity at the model
		// level based on validation rules.  comment this line out if this is not desired
		if (!$this->Validate()) throw new Exception('Unable to Save Usuario: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>
