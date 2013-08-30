<?php

namespace JHV\Bundle\SeoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * GenerateSitemapCommand.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class GenerateSitemapCommand extends ContainerAwareCommand
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('seo:generate:sitemap')
            ->setDescription('Generates a sitemap based on registered SEOs on database.')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Defines seo filename',
                'sitemap.xml'
            )
            ->addOption(
                'dir',
                null,
                InputOption::VALUE_OPTIONAL,
                'Specify the directory where file will be dumped.'
            )
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'Generate all registered URLs in the sitemap, but only those marked as robots index will be dumped.'
            )
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename       = $input->getArgument('filename');
        $directory      = $input->getOption('dir');
        $onlyIndexed    = !$input->getOption('all');

        // Buscar o container da aplicação
        $container      = $this->getContainer();

        // Verificar existência do serviço para geração de sitemap
        if (false === $container->has('jhv.sitemap_manager.seo')) {
            $output->writeln(sprintf(
                'You cannot generate a sitemap because database option was disabled for SEO.'
            ));
        }
        // Caso existir, poderá efetuar a geração
        else {
            $sitemap        = $container->get('jhv.sitemap_manager.seo');
            $filename       = (null !== $directory) ? $sitemap->generateOnDirectory($directory, $filename, $onlyIndexed) : $sitemap->generate($filename, $onlyIndexed);;
            $output->writeln(sprintf(
                'Your file was sucessful generated with name %s', $filename
            ));
        }
    }

    /**
     * @inheritdoc
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if ('sitemap.xml' == $input->getArgument('filename')) {
            $filename = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a filename (sitemap.xml):',
                function($filename) {
                    if (empty($filename)) {
                        $filename = 'sitemap.xml';
                    }

                    return $filename;
                }
            );
            $input->setArgument('filename', $filename);
        }
    }

}