<?php

namespace BrauneDigital\PitcherBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pitcher:send_message')
            ->setDescription('Send message over pitcher')
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Message'
            )
            ->addArgument(
                'level',
                InputArgument::REQUIRED,
                'Level of message. Allowed are okay, debug, info, error, critical'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');
        $level = $input->getArgument('level');

        if(!in_array($level, ['okay', 'debug', 'info', 'error', 'critical'])) {
            $output->writeln('Level should be one of the following options: okay, debug, info, error, critical');
            return;
        }

        $pitcherClient = $this->getContainer()->get('pitcher.client');
        $pitcherClient->pitch($level, $message);

        $output->writeln('Message was pitched');
    }
}
