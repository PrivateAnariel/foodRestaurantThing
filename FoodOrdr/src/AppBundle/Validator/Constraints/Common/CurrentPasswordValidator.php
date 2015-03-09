<?php
namespace AppBundle\Validator\Constraints\Common;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use JMS\DiExtraBundle\Annotation\Validator;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Inject;

/**
 * @Validator("user.validator.current_password")
 */
class CurrentPasswordValidator extends ConstraintValidator
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * @InjectParams({
     *     "encoderFactory"  = @Inject("security.encoder_factory"),
     *     "securityContext" = @Inject("security.context")
     * })
     *
     * @param EncoderFactoryInterface  $encoderFactory
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EncoderFactoryInterface  $encoderFactory,
                                SecurityContextInterface $securityContext)
    {
        $this->encoderFactory  = $encoderFactory;
        $this->securityContext = $securityContext;
    }

    /**
     * @param string     $currentPassword
     * @param Constraint $constraint
     * @return boolean
     */
    public function isValid($currentPassword, Constraint $constraint)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $encoder = $this->encoderFactory->getEncoder($currentUser);
        $isValid = $encoder->isPasswordValid(
            $currentUser->getPassword(), $currentPassword, null
        );

        if (!$isValid) {
            $this->setMessage($constraint->message);
            return false;
        }

        return true;
    }
}