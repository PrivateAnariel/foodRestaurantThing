<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Issue;

class ClientToIdTransformer implements DataTransformerInterface
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
     * Transforms an object (Client) to a string (idClient).
     *
     * @param  Client|null $issue
     * @return string
     */
    public function transform($cli)
    {
        if (null === $cli) {
            return "";
        }

        return $cli->getIdClient();
    }

    /**
     * Transforms a string (idClient) to an object (Client).
     *
     * @param  string $idClient
     *
     * @return Client|null
     *
     * @throws TransformationFailedException if object (Client) is not found.
     */
    public function reverseTransform($idClient)
    {
        if (!$idClient) {
            return null;
        }

        $cli = $this->om
            ->getRepository('AppBundle:Client')
            ->findOneBy(array('idClient' => $idClient));

        if (null === $cli) {
            throw new TransformationFailedException(sprintf(
                'An Client with id "%s" does not exist!',
                $idClient
            ));
        }

        return $cli;
    }
}