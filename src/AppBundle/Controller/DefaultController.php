<?php

namespace AppBundle\Controller;

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

    public function searchBarAction(){
        $query = null;
        if(!empty($_GET)){
            if(!is_null($_GET['query'])){
                $query = $_GET['query'];
            }
        }

        $data = ['query' => $query];

        $form = $this->get('form.factory')->createNamedBuilder(null, FormType::class, $data, array('csrf_protection' => false))
            ->setMethod('GET')
            ->setAction($this->generateUrl('search'))
            ->add('query', SearchType::class, array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 3)),
                ),
                "label" => false,
                "attr" => ["placeholder" => "Search"]
            ))
            ->getForm();

        return $this->render('AppBundle:default:search-bar.html.twig', [
            'form' => $form->createView()
        ]);


    }

    public function searchAction(Request $request){

        if($request->isMethod('GET') && !is_null($request->get('query'))){
            $query = $request->get('query');

            $em = $this->getDoctrine()->getManager();
            $videos = $em->getRepository('AppBundle:Video')->search($query);

            return $this->render('AppBundle::video/index.html.twig', [
                'videos' => $videos
            ]);
       }

        return $this->redirectToRoute('home');
    }
}
