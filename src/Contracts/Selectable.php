<?php

namespace LindenCMS\Cms\Contracts;

/**
 * Settings for the Relations nodes - _BelongsTo, _HasMany
 */
interface Selectable
{
    /**
     * Prop that should be use as an option Lable
     * @return string
     */
    public function optionLabelProp(): string;

    /**
     * Prop that should be use as an option Value
     * @return string
     */
    public function optionValueProp(): string;

    /**
     * Props that should be use in search query
     * @return array
     */
    public function optionSearchProps(): array;

    /**
     * Label that should be displayed as an option
     * @return array
     */
    public function optionLabel(): string;
}