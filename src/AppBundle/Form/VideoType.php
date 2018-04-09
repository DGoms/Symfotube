<?php
/**
 * Created by PhpStorm.
 * User: goms
 * Date: 24/01/18
 * Time: 10:48
 */

namespace AppBundle\Form;

use AppBundle\Entity\Video;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class VideoType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('category')
//            ->add('category', EntityType::class, array(
//                'class' => 'AppBundle:VideoCategory',
//                'choice_label' => 'name',
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('vc')
//                        ->orderBy('vc.name', 'ASC');
//                }
//            ))
            ->add('thumbnailFile', VichImageType::class, ['allow_delete' => true])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $video = $event->getData();
            $form = $event->getForm();

            // checks if the Video object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$video || null === $video->getId()) {
                $form->add('videoFile', VichFileType::class, ['allow_delete' => false]);
            }
        });
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Video::class,
        ));
    }
}