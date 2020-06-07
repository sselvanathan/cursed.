<?php

    declare(strict_types=1);

    namespace Controllers\Home;

    use Common\Controller;
    use Database\Config\EntityManagerConfig;

    class HomeController extends Controller
    {
        private const MODULE = 'Home';

        public function __construct($args)
        {
            parent::__construct(
                [
                    $this->setTemplatePath(self::MODULE),
                    $this->setTemplateData(
                        $this->getTwigData()
                    ),
                ]
            );
        }

        public function getModule(): array
        {
            return ['module' => self::MODULE];
        }

        public function getTwigData(): array
        {
            return array_merge(
                $this->getModule(),
                $this->getAllBlogPosts()
            );
        }

        public function getAllBlogPosts()
        {
            $entityManager = (new EntityManagerConfig)->createEntityManager();
            $blogPostRepository = $entityManager->getRepository('Database\Entities\Blog\BlogEntity');
            $blogPosts = $blogPostRepository->findAll();
            $allBlogPosts = [];

            foreach ($blogPosts as $blogPost) {
                $allBlogPosts[] = [
                    "id" => $blogPost->getId(),
                    "title" => $blogPost->getTitle(),
                    "post" => $blogPost->getPost(),
                    "created_at" => $blogPost->getCreatedAt(),
                ];
            }
            return ['allBlogPosts' => $allBlogPosts];
        }
    }

