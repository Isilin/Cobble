<?php
    namespace Cobble;

    interface iModule
    {
        public function initModule();
        public function endModule();

        public function getModuleID(): string;
        public function setActive($value: bool);
        public function isActive(): bool;
    }