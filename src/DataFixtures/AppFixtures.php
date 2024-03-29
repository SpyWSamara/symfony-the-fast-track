<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $samara = new Conference();
        $samara->setCity('Samara');
        $samara->setYear('2020');
        $samara->setIsInternational(true);
        $manager->persist($samara);

        $saratov = new Conference();
        $saratov->setCity('Saratov');
        $saratov->setYear('2021');
        $saratov->setIsInternational(false);
        $manager->persist($saratov);

        $comment1 = new Comment();
        $comment1->setConference($samara);
        $comment1->setAuthor('Tester');
        $comment1->setEmail('test@local.tld');
        $comment1->setText('It was great!');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($samara);
        $comment2->setAuthor('Anybody');
        $comment2->setEmail('anyone@anydomain.tld');
        $comment2->setText('Anyone can write anything. But we not publish this.');
        $manager->persist($comment2);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $manager->flush();
    }
}
