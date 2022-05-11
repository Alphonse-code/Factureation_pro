<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClient', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Nom du client", 'class' => "my-1", "id" => "nomClient"]
            ])
            ->add('prenomClient', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Prénom du client", 'class' => "my-1", "id" => "prenomClient"]
            ])
            ->add('tel', TelType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Tél client", 'class' => "my-1"]
            ])
            ->add('tel2', TelType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Tél2 client", 'class' => "my-1"]
            ])
            ->add('nomSociete', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Nom du Societé", 'class' => "my-1"]
            ])
            ->add('fixe', TelType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Fixe", 'class' => "my-1"]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Email du Client", 'class' => "my-1"]
            ])
            ->add('codePostalClient', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Code Postal", 'class' => "my-1"]
            ])
            ->add('villeClient', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "Ville", 'class' => "my-1"]
            ])
            ->add('nomRueClient', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Nom Rue", 'class' => "my-1"]
            ])
            ->add('numRueClient', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Numéro Rue", 'class' => "my-1"]
            ])
            ->add('adresseFactureClient', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "Adresse de Facturation", 'class' => ""]
            ])
            ->add('numeroDeSerieClient', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "N° de Série", 'class' => "my-1", 'id' => 'serieEntreprise']
            ])
            ->add('paysClient', CountryType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Pays", 'class' => "my-1"]
            ])
            ->add('titreEntrepriseClient', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => "Titre de la Societé", 'class' => "my-0", 'id' => 'titreEntreprise']
            ])
            ->add(
                'coditionDePaiement',
                ChoiceType::class,
                [
                    'label' => false,
                    'choices'  =>
                    [
                        '15 jours' => '15',
                        '30 jours' => '30',
                        '45 jours' => '45',
                        '60 jours' => '60'
                    ],
                    'multiple' => false,
                    'expanded' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}