<?php
// src/Form/DataTransformer/IssueToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\ActeurPartie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ActeurPartieDataTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (pouvoirPartie) to a string (number).
     *
     * @param  ActeurPartie|null $issue
     * @return string
     */
    public function transform($acteurPartie)
    {
        if (null === $acteurPartie) {
            return '';
        }

        return $acteurPartie->getId();
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

        $acteurPartie = $this->entityManager
            ->getRepository(ActeurPartie::class)
            // query for the issue with this id
            ->find($id)
        ;

        if (null === $acteurPartie) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }

        return [$acteurPartie];
    }
}
