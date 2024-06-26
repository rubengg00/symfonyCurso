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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default")
     */
    public function index(GiftsService $gifts, Request $request, SessionInterface $session)
    {

        // ------------- 1.- Persistencia de datos BBDD -------------
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

        // ------------- 2.-Notificaciones flash -------------

        // $this->addFlash(
        //     'notice',
        //     'Tus cambios han sido guardados!'
        // );

        // $this->addFlash(
        //     'warning',
        //     'Tus cambios no han sido guardados!'
        // );

        // ------------- 3.-Variables de sesiones -------------
        // $session->set('name', 'session value');

        // // $session->remove('name');

        // $session->clear();

        // if($session->has('name'))
        // {
        //     exit($session->get('name'));
        // }

        // ------------- 4.- Creacion de cookies -------------

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

        // ------------- 5.- Obtener GET y POST -------------
        // exit($request->query->get('page', 'default'));   OBTENER PARAMETROS GET
        // exit($request->server->get('HTTP_HOST'));
        // $request->isXmlHttpRequest(); // Es una peticion Ajax?
        // $request->request->get('page'); // OBTENER PARAMETROS POST
        // $request->files->get('foo'); // OBTENER ARCHIVOS SUBIDOS

        // ------------- 6.- Manejo de excepciones -------------
        // if ($users) {
        //     throw $this->createNotFoundException('No existen ningun usuario');
        // }


        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

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
     * }, name="about_us")
     */
    public function index4()
    {
        return new Response('Translated routes');
    }

    /**
     * @Route("/generate-url/{param?}", name="generate_url")
     */
    public function generate_url()
    {
        exit($this->generateUrl(
            'generate_url',
            array('param'=>10),
            UrlGeneratorInterface::ABSOLUTE_URL
        ));
    }

    /**
     * @Route("/download", name="download")
     */
    public function download()
    {
        $path = $this->getParameter('download_directory');
        return $this->file($path.'file.pdf');
    }

    /**
     * @Route("/redirect-test", name="redirect_test")
     */
    public function redirectTest()
    {
        return $this->redirectToRoute('route_to_redirect', array('param'=>10));
    }

    /**
     * @Route("/url-to-redirect/{param?}", name="route_to_redirect")
     */
    public function methodToRedirect()
    {
        exit("Test redirection");
    }

    /**
     * @Route("/forwarding-to-controller")
     */
    public function forwardingToController()
    {
        $response = $this->forward(
            "App\Controller\DefaultController::methodToForwardTo",
            array('param'=>'1')
        );

        return $response;
    }

    /**
     * @Route("/url-to-forward-to/{param?}", name="route_to_forward_to")
     */
    public function methodToForwardTo($param)
    {
        exit('Test controller forwarding - '.$param);
    }

}
