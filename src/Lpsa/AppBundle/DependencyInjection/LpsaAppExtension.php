<?php

namespace Lpsa\AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class LpsaAppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('events.yml');
        $loader->load('managers.yml');
        $loader->load('repositories.yml');
        $loader->load('security.yml');
        //form
        $loader->load('form/direction.yml');
        $loader->load('form/gravite.yml');
        $loader->load('form/impactmediatique.yml');
        $loader->load('form/fonction.yml');
        $loader->load('form/depotcategorie.yml');
        $loader->load('form/depot.yml');
        $loader->load('form/impactclient.yml');
        $loader->load('form/evenementstatut.yml');
        $loader->load('form/evenementcategorie.yml');
        $loader->load('form/evenement.yml');
        $loader->load('form/heuretravailcategorie.yml');
        $loader->load('form/heuretravail.yml');
        $loader->load('form/environnement.yml');
        $loader->load('form/dysfonctionnement.yml');
        $loader->load('form/responsableservice.yml');
        $loader->load('form/typecorporel.yml');
        $loader->load('form/corporel.yml');
        $loader->load('form/typemateriel.yml');
        $loader->load('form/materiel.yml');
        $loader->load('form/typeenvironnement.yml');
        $loader->load('form/evenementactionprogresstatus.yml');
        $loader->load('form/departement.yml');
        $loader->load('form/service.yml');
        $loader->load('form/objectifdepot.yml');
        $loader->load('form/exerciceurgence.yml');
        $loader->load('form/toolbox.yml');
        $loader->load('form/visite.yml');
        $loader->load('form/objectifltirtrir.yml');
        $loader->load('form/piezometre.yml');
        $loader->load('form/decanteur.yml');
        $loader->load('form/laboratoire.yml');
        $loader->load('form/indicateurtransport.yml');
        $loader->load('form/paqssse.yml');
        $loader->load('form/paq3segravite.yml');
        $loader->load('form/fuiteproduit.yml');
        $loader->load('form/objectifkpihse.yml');
    }
}
