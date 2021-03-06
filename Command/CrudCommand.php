<?php

/*
 * This file is part of the CrudGeneratorBundle
 *
 * It is based/extended from SensioGeneratorBundle
 *
 * (c) Jordi Llonch <llonch.jordi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itscaro\CrudGeneratorBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Itscaro\CrudGeneratorBundle\Generator\CrudGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;


class CrudCommand extends GenerateDoctrineCrudCommand
{
    protected $generator;
    protected $formGenerator;

    protected function configure()
    {
        parent::configure();

        $this->setName('itscaro:generate:crud');
        $this->setDescription('A CRUD generator with paginating and filters.');
    }

    protected function createGenerator($bundle = null)
    {
        return new CrudGenerator($this->getContainer()->get('filesystem'));
    }

    protected function getSkeletonDirs(BundleInterface $bundle = null)
    {
        $skeletonDirs = array();

        if (isset($bundle) && is_dir($dir = $bundle->getPath().'/Resources/ItscaroCrudGeneratorBundle/skeleton')) {
            $skeletonDirs[] = $dir;
        }

        if (is_dir($dir = $this->getContainer()->get('kernel')->getRootdir().'/Resources/ItscaroCrudGeneratorBundle/skeleton')) {
            $skeletonDirs[] = $dir;
        }

        $skeletonDirs[] = __DIR__.'/../Resources/skeleton';
        $skeletonDirs[] = __DIR__.'/../Resources';

        return $skeletonDirs;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getQuestionHelper();
        $dialog->writeSection($output, 'ItscaroCrudGeneratorBundle');

        parent::interact($input, $output);
    }
}
