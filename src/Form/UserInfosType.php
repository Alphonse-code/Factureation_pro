<?php

namespace App\Form;

use App\Entity\UserInfos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pays = new Pays();
        
        $builder
            ->add('logo', FileType::class, [
                'label' => false,
                'data_class' => null
            ])
            ->add('nomEntreprise')
            ->add('emailEntreprise')
            ->add('numSiret')
            ->add('numTVA')
            ->add('statJuridique')
            ->add('rcs')
            ->add('TVADefault')
            ->add('pays', ChoiceType::class, [
                'choices'  => $pays->lister_pays()           
            ])
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('siteWeb')
            ->add('interPrenom')
            ->add('interNom')
            ->add('interEmail', EmailType::class)
            ->add('interPortable');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfos::class,
        ]);
    }
}