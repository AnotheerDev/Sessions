<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Session;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findNonInscrits($session_id){
        $em=$this->getEntityManager();
        $sub=$em->createQueryBuilder();
    
        $qb=$sub;
        //selectionne tous les "apprenants" d'une session dont l'id est passé en paramètre
        $qb->select('s')
            ->from('App\Entity\User','s')
            ->leftJoin('s.sessions', 'se')
            ->where('se.id = :id');
            
            $sub = $em->createQueryBuilder();
            // sélectionner tous les "apprenants" qui ne SONT PAS (NOT IN) dans le résultat précédent
            // on obtient les "apprenants" non inscrits pour une session avec id
            $sub->select('st')
                ->from('App\Entity\User', 'st')
                ->where($sub->expr()->NotIn('st.id', $qb->getDQL()))
                // requête paramétrée
                ->setParameter('id', $session_id)
                // trier la liste des "apprenants" par lastname
                ->orderBy('st.lastName');
            
            //return le resultat 
            $query = $sub->getQuery();
            return $query->getResult();
    }
}
