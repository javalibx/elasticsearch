<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Contracts;

/**
 * Interface QueryInterface
 * @package Kabunx\Elasticsearch\Contracts
 */
interface QueryInterface
{

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function body(): array;

    /**
     * @param string $field
     * @return $this
     */
    public function setField(string $field): static;

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static;

    /**
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple(bool $multiple): static;
}
