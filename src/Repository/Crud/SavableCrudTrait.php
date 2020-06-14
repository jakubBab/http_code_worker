<?php

declare(strict_types=1);

namespace App\Repository\Crud;

use Doctrine\ORM\EntityManager;

trait SavableCrudTrait
{
    public function save(object $object)
    {
        $entityManager = $this->getEntityManager();
        if (null === $object->getId()) {
            $entityManager->persist($object);
        }
        $entityManager->flush();
    }

    public function saveMultiple(array $entities)
    {
        $entityManager = $this->getEntityManager();
        $index = 0;
        foreach ($entities as $object) {
            if (null === $object->getId()) {
                $entityManager->persist($object);
            }
            if ($index % 10 == 0) {
                $entityManager->flush();
            }
            $index += 1;
        }
        $entityManager->flush();
    }

    public function delete(array $items)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        foreach ($items as $item) {
            $entityManager->remove($item);
        }
        $entityManager->flush();
    }
}
