<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Illustration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="post_index")
     */
public function index(EntityManagerInterface $em)
{

  $posts = $em->getRepository(Post::class)->findAll();

  return $this->render('post/index.html.twig', [
      'posts' => $posts
    ]);
}

        /**
     * @Route("/posts/add", name="post_add")
     */
    public function add()
    {


    // dump($post);
    return $this->render('post/add.html.twig', [
    ]);
  }
    
    /**
     * @Route("/posts/addSave", name="post_addSave")
     */
    public function addSave(EntityManagerInterface $em)
    {
    
    $request = Request::createFromGlobals();

    $illustration = new Illustration();
    $illustration->setDescription($request->request->get('description'))
                ->setName($request->request->get('illustration'))         
                ->setCreatedAt(new \DateTime($request->request->get('publishedAt')));
    
    $post = new Post();
    // renseigner les informations
    $post->setTitle($request->request->get('title'))
         ->setBody($request->request->get('body'))
         ->setPublishedAt(new \DateTime($request->request->get('publishedAt')))
         ->setIllustration($illustration);
    // persister l'entité
    $em->persist($post);
    $em->persist($illustration);
    // déclencher le traitements SQL
    $em->flush();

    return $this->redirect('/posts', 308);
    }


    /**
     * @Route("/posts/{id}", name="post_show")
     */
    public function show(Post $post)
    {
      dump($post);
      return new Response(
      '<html><body>
       <h1> route /posts/add - add()</h1>
       </body></html>'
    );
    }

        /**
     * @Route("/posts/{id}/delete", name="post_delete")
     */
    public function delete(EntityManagerInterface $em,Post $post)
    {
      // construire l'objet Post associé à $id
      $em->remove($post);
      // déclencher le traitements SQL
      $em->flush();
      return $this->redirect('/posts', 308);
    }

            /**
     * @Route("/posts/{id}/edit", name="post_edit")
     */
    public function edit(Post $post, EntityManagerInterface $em)
    {

    $post->setTitle('TEST');
    // $post->setUpdatedAt(new \DateTime());
    $em->flush();
    dump($post);
    return new Response(
        '<html><body>
           <h1>route /posts/{id}/edit - edit()</h1>
         </body></html>'
    );
    }
}
