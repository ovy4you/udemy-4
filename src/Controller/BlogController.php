<?php
/**
 * Created by PhpStorm.
 * User: ovy_4
 * Date: 3/16/2019
 * Time: 6:56 PM
 */

namespace App\Controller;


use App\Service\Greeting;

use Http\Discovery\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/")
 */
class BlogController extends AbstractController
{

    /**
     * @var Greeting
     */
    private $greeting;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(Greeting $greeting, SessionInterface $session)
    {
        $this->greeting = $greeting;
        $this->session = $session;
    }

    /**
     * @Route("", name="app_blog")
     */
    public function index()
    {
        $posts = $this->session->get('posts');
        return $this->render('/blog/index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("add", name="blog_add")
     */
    public function add()
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title'=>'A random title' . rand(1, 500),
            'text' => 'Some random text nr' . rand(1, 500)
        ];

        $this->session->set('posts', $posts);
        return $this->redirect('/blog');
    }


    /**
     * @Route("/show/{id}", name="blog_show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');
        if (empty($posts[$id])) {
            throw  new NotFoundException('post not found');
        }

        return $this->render('/blog/post.html.twig', ['id' => $id, 'post' => $posts[$id]]);
    }
}