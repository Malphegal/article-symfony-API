<?php

namespace App\DataPersister;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommentDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;
    private $_slugger;

    public function __construct(
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ) {
        $this->_entityManager = $entityManager;
        $this->_slugger = $slugger;

        json_encode(get_object_vars($this));
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Comment;
    }

    /**
     * @param Comment $data
     */
    public function persist($data, array $context = [])
    {
        //$e = new \Exception();
        //dump(str_replace('C:\Users\Stagiaire\Documents\Serveurs\symfony-api', '', $e->getTraceAsString()));
        //dump(debug_print_backtrace ());
        //$articleId = $data->getArticle();
        //dump($articleId);
        //$articleId = 6;
        //$article = $this->_entityManager->find(\App\Entity\Article::class, $articleId);
        //$data->setArticle($article);
        $data->setCreatedAt(new \Datetime());

        //if (($context['collection_operation_name'] ?? null) !== 'post')
        //    $data->setUpdatedAt(new \DateTime());

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}