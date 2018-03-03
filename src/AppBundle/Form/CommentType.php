<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 24/01/18
 * Time: 10:48
 */

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use AppBundle\Form\DataTransformer\VideoToIntTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CommentType extends AbstractType{

    private $transformer;

    public function __construct(VideoToIntTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, array("label" => false, "attr" => ["placeholder" => "Add a comment"]))
            ->add('video', HiddenType::class, array('required' => true, 'invalid_message' => 'That is not a valid video id',))
            ->add('save', SubmitType::class, array("label" => "Publish", "attr" => ["class" => "text-right"]))
        ;

        $builder->get('video')
            ->addModelTransformer($this->transformer);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}