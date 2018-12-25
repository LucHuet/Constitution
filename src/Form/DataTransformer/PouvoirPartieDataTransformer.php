<?php
// src/Form/DataTransformer/IssueToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\PouvoirPartie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PouvoirPartieDataTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (pouvoirPartie) to a string (number).
     *
     * @param  PouvoirPartie|null $issue
     * @return string
     */
    public function transform($pouvoirPartie)
    {
        if (null === $pouvoirPartie) {
            return '';
        }

        return $pouvoirPartie->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $id
     * @return PouvoirPartie|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($id)
    {
        dump($id);
        // no issue number? It's optional, so that's ok
        if (!$id) {
            return;
        }

        $pouvoirPartie = $this->entityManager
            ->getRepository(PouvoirPartie::class)
            // query for the issue with this id
            ->find($id)
        ;

        if (null === $pouvoirPartie) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }

        return $pouvoirPartie;
    }
}
