<?php

namespace App\Repository;

use App\Entity\Corps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Corps>
 */
class CorpsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Corps::class);
    }

    //    /**
    //     * @return Corps[] Returns an array of Corps objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Corps
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function recupImage()
    {
        $corps = new Corps();

        // Récupérez le BLOB (ressource)

        $imageBlob = $corps->getImage();

        if (is_resource($imageBlob)) {
            // Convertissez la ressource en une chaîne
            $imageContent = stream_get_contents($imageBlob);
            fclose($imageBlob); // Fermez la ressource une fois utilisée
        } else {
            $imageContent = $imageBlob; // Si ce n'est pas une ressource, utilisez-la directement
        }

        // Encodez en Base64
        $imageBase64 = base64_encode($imageContent);

        return $this->render('corps/index.html.twig', [
            'imageBase64' => $imageBase64,
        ]);
    }
}
