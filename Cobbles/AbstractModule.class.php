<?php
    namespace Cobble;

    abstract class AbstractModule implements iModule
    {
        protected $id = "";
        protected bool $active = true;

        public function __construct()
        {
        }

        public function getModuleID(): string
        {
            return $this->id;
        }

        public function setActive($value: bool)
        {
            $this->active = $value;
        }

        public function isActive(): bool
        {
            return $this->active;
        }
    }