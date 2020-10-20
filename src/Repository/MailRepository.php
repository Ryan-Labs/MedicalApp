<?php

namespace App\Repository;

use App\Entity\Mail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @method Mail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mail[]    findAll()
 * @method Mail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mail::class);
    }

    public function sendMail(Mail $mail, MailerInterface $mailer){
        $email = (new Email())
            ->from("r.labeni@ecole-ipssi.net")
            ->to($mail->getRecipient())
            ->subject($mail->getSubject())
            ->text($mail->getContent());

        $mailer->send($email);
    }

    // /**
    //  * @return Mail[] Returns an array of Mail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mail
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
