<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['onkeyup' => "this.value=this.value.replace('@','')"],
            ])
            ->add('objet',TextType::class)
            ->add('email',EmailType::class)
            ->add('message',TextareaType::class)
            ->add('verif', TextType::class,[
                'attr'=> ['placeholder' => "Combien font 7+4 ?"]
            ])
            ->add('send', SubmitType::class,[
                'attr'=> ['class' => "comment-submit"],
                'label' => "Envoyer le message"
            ])
        ;
    }
}
