<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Tag::class, 10, function(Tag $tag) {
            $tag->setName($this->faker->realText(20));
        });
        $manager->flush();
    }
}
