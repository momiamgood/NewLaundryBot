<?php

namespace Base\Interfaces;

interface Step {
    public function validate();
    public function add();
    public function message();
}