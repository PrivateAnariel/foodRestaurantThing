<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Issue;

class EntToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (Entrepreneur) to a string (idEntrepreneur).
     *
     * @param  Entrepreneur|null $issue
     * @return string
     */
    public function transform($ent)
    {
        if (null === $ent) {
            return "";
        }

        return $ent->getIdEntrepreneur();
    }

    /**
     * Transforms a string (idEntrepreneur) to an object (Entrepreneur).
     *
     * @param  string $idEntrepreneur
     *
     * @return Entrepreneur|null
     *
     * @throws TransformationFailedException if object (Entrepreneur) is not found.
     */
    public function reverseTransform($idEntrepreneur)
    {
        if (!$idEntrepreneur) {
            return null;
        }

        $ent = $this->om
            ->getRepository('AppBundle:Entrepreneur')
            ->findOneBy(array('idEntrepreneur' => $idEntrepreneur));

        if (null === $ent) {
            throw new TransformationFailedException(sprintf(
                'An Entrepreneur with id "%s" does not exist!',
                $idEntrepreneur
            ));
        }

        return $ent;
    }
}