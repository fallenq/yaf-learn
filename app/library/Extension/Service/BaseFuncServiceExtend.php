<?php
namespace Extension\Service;

trait BaseFuncServiceExtend
{
    /**
     * Get instance of FuncService
     * @return BaseFuncServiceExtend
     */
    public static function getInstance()
    {
        return new self();
    }
}