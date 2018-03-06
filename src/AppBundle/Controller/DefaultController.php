<?php

namespace AppBundle\Controller;

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

        return $this->render('AppBundle:default:search-bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function searchAction(Request $request){

        if($request->isMethod('GET') && !is_null($request->get('query'))){
            $query = $request->get('query');

            $em = $this->getDoctrine()->getManager();
            $videos = $em->getRepository('AppBundle:Video')->search($query);
            $users = $em->getRepository('AppBundle:User')->search($query);

            return $this->render('AppBundle::video/index.html.twig', [
                'query' => $query,
                'users' => $users,
                'videos' => $videos
            ]);
       }

        return $this->redirectToRoute('home');
    }
}
