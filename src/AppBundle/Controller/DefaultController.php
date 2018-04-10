<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use function PHPSTORM_META\type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function homeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Video')->findAll();

        return $this->render('@App/default/home.html.twig', [
            'videos' => $videos
        ]);
    }

    public function menuAction(Request $request){
        $menu = [];
        array_push($menu, ['icon' => 'home', 'label' => 'Home', 'path' => $this->generateUrl('home')]);

        $menu_category = [];
        $video_categories = $this->getDoctrine()->getRepository('AppBundle:VideoCategory')->findAllExceptDefault();
        foreach($video_categories as $category){
            array_push($menu_category, [
                'icon' => $category->getIcon(),
                'label' => $category->getName(),
                'path' => $this->generateUrl('video_category_list', ['name' => $category->getName()])
            ]);
        }
        $menu['Category'] = $menu_category;

        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $menu_user = [];
            array_push($menu_user, ['icon' => 'history', 'label' => 'History', 'path' => $this->generateUrl('history')]);
            array_push($menu_user, ['icon' => 'face', 'label' => 'Profile', 'path' => $this->generateUrl('fos_user_profile_show')]);
            array_push($menu_user, ['icon' => 'backup', 'label' => 'Publish a video', 'path' => $this->generateUrl('video_new')]);
            $menu['User'] = $menu_user;

            if($this->isGranted('ROLE_ADMIN')){
                $menu_admin = [];
                array_push($menu_admin, ['icon' => 'supervisor_account', 'label' => 'Administration', 'path' => $this->generateUrl('sonata_admin_dashboard')]);
                $menu['Administration'] = $menu_admin;
            }
        }

        return $this->render('@App/menu.html.twig', ['menu' => $menu]);
    }

    /**
     * Render the search bar
     * @param string|null $query
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchBarAction(string $query = null){

        $data = ['query' => $query];

        $form = $this->get('form.factory')->createNamedBuilder(null, FormType::class, $data, array('csrf_protection' => false))
            ->setMethod('GET')
            ->setAction($this->generateUrl('search'))
            ->add('query', SearchType::class, array(
                'constraints' => array(
                    new NotBlank(),
                ),
                "label" => false,
                "attr" => ["placeholder" => "Search"]
            ))
            ->getForm();

        return $this->render('AppBundle:default:search_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function searchAction(Request $request){

        if($request->isMethod('GET') && !is_null($request->get('query'))){
            $query = $request->get('query');

            $em = $this->getDoctrine()->getManager();
            $videos = $em->getRepository('AppBundle:Video')->search($query);
            $users = $em->getRepository('AppBundle:User')->search($query);

            return $this->render('@App/default/home.html.twig', [
                'query' => $query,
                'users' => $users,
                'videos' => $videos
            ]);
       }

        return $this->redirectToRoute('home');
    }
}
