<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default")
     */
    public function index(GiftsService $gifts, Request $request, SessionInterface $session)
    {
        // $entityManager = $this->getDoctrine()->getManager();

        // $user = new User;
        // $user->setName('Ruben');

        // $user1 = new User;
        // $user1->setName('Anthony');

        // $user2 = new User;
        // $user2->setName('John');

        // $user3 = new User;
        // $user3->setName('Susan');

        // $entityManager->persist($user);
        // $entityManager->persist($user1);
        // $entityManager->persist($user2);
        // $entityManager->persist($user3);

        // exit($entityManager->flush());

        // $this->addFlash(
        //     'notice',
        //     'Tus cambios han sido guardados!'
        // );

        // $this->addFlash(
        //     'warning',
        //     'Tus cambios no han sido guardados!'
        // );

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $session->set('name', 'session value');

        // $session->remove('name');

        $session->clear();

        if($session->has('name'))
        {
            exit($session->get('name'));
        }

        // $cookie = new Cookie(
        //     'my_cookie',                        //Nombre de la cookie
        //     'cookie_value',                     //Valor de la cookie
        //     time() + ( 2 * 365 * 24 * 60 * 60)  //Expira despues de 2 años
        // );

        // $res = new Response();

        // $res->headers->setCookie( $cookie );

        // $res->send();

        // $res = new Response();

        // $res->headers->clearCookie( 'my_cookie' );

        // $res->send();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'randomGift' => $gifts->gifts
        ]);
    }

    /**
     * @Route("/blog/{page?}", name="blog_list", requirements={"page"="\d+"})
     */
    public function index2()
    {
        return new Response('<p>Optional parameters in url and requirements for parameters</p>');
    }

    /**
     * @Route(
     *      "/articles/{_locale}/{year}/{slug}/{category}",
     *      defaults={"category": "computers"},
     *      requirements={
     *          "_locale": "en|es",
     *          "category": "computers|rtv",
     *          "year": "\d+"
     *      }
     * )
     */
    public function index3()
    {
        return new Response('An advanced route example!');
    }

    /**
     * @Route({
     *      "es": "/sobre-nosotros",
     *      "en": "/about-us"
     * }, name="about-_us")
     */
    public function index4()
    {
        return new Response('Translated routes');
    }

}
