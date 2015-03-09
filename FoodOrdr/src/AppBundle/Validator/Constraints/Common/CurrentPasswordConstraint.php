<?php
namespace AppBundle\Validator\Constraints\Common;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CurrentPasswordConstraint extends Constraint
{
    public $message = "Le mot de passe ne corresponds pas à l'utilisateur connecté";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'common.validator.current_password';
    }
}