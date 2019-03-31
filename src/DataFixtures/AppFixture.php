<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixture extends Fixture
{

    private const USERS = [
        [
            'username' => 'john_doe',
            'email' => 'ovidiu@ovidiu.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
        ],
        [
            'username' => 'rob_smith',
            'email' => 'ovidiu@ciuca.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(
                self::POST_TEXT[rand(0, count(self::POST_TEXT) - 1)]
            );
            $microPost->setUser($this->getReference(self::USERS[rand(0, count(self::USERS) - 1)]['email']));
            $date = new \DateTime();
            $date->modify('-' . rand(1, 10) . 'day');
            $microPost->setTime($date);
            $manager->persist($microPost);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    'ovidiu'
                )
            );

            $this->addReference($userData['email'], $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
