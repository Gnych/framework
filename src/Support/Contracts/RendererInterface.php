<?php
namespace Lavender\Support\Contracts;

use Illuminate\View\Factory;

interface RendererInterface
{
    public function __construct(Factory $factory);

    public function render(WorkflowInterface $workflow);
}