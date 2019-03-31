<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


/**
 * @Route("/micro")
 */
class MicroPostController extends Controller
{

    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(MicroPostRepository $microPostRepository, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router, FlashBagInterface $flashBag, AuthorizationCheckerInterface $authorizationChecker)
    {
        /** @var  microPostRepository */
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @Route("/post", name="micro_post")
     */
    public function index()
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $this->microPostRepository->findBy([], ['time' => 'DESC']),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     */
    public function edit(MicroPost $microPost, Request $request)
    {
        if ($this->authorizationChecker->isGranted('edit', $microPost)) {
            throw new UnauthorizedHttpException();
        }

        $microPost->setTime(new \DateTime());

        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($microPost);
            $this->entityManager->flush();
            return new RedirectResponse($this->router->generate('micro_post'));
        }

        return $this->render('micro_post/add.html.twig', [
            'form' => $form->createView(),
        ]);

        return $this->render('micro_post/post.html.twig', [
            'post' => $microPost,
        ]);
    }

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();

        $microPost = new MicroPost();
        $microPost->setUser($user);
        $microPost->setTime(new \DateTime());

        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($microPost);
            $this->entityManager->flush();
            return new RedirectResponse($this->router->generate('micro_post'));
        }

        return $this->render('micro_post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post(MicroPost $microPost)
    {

        return $this->render('micro_post/post.html.twig', [
            'post' => $microPost,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */

    public function delete(MicroPost $microPost)
    {
        $this->entityManager->remove($microPost);
        $this->entityManager->flush();
        $this->flashBag->add('notice', 'Success');
        return new RedirectResponse($this->router->generate('micro_post'));
    }
}
