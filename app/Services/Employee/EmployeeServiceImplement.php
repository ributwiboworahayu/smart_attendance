<?php

namespace App\Services\Employee;

use LaravelEasyRepository\Service;
use App\Repositories\Employee\EmployeeRepository;

class EmployeeServiceImplement extends Service implements EmployeeService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(EmployeeRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
}
