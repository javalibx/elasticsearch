<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Sorts;

class ScriptSort extends Sort
{

    /**
     * @var string
     */
    protected string $script;

    /**
     * @var string
     */
    protected string $direction = 'asc';

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            '_script' => $this->merge([
                'script' => $this->script,
                'type' => 'number',
                'order' => $this->direction
            ])
        ];
    }


    /**
     * @return $this
     */
    public function random(): static
    {
        return $this->setScript('Math.random()');
    }

    /**
     * @param string $script
     * @return $this
     */
    public function setScript(string $script): static
    {
        $this->script = $script;

        return $this;
    }
}
