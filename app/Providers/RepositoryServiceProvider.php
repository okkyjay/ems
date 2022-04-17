<?php

namespace App\Providers;

use App\EMS\Complaint\Repositories\ComplaintRepository;
use App\EMS\Complaint\Repositories\ComplaintRepositoryInterface;
use App\EMS\Country\Repositories\CountryRepository;
use App\EMS\Country\Repositories\CountryRepositoryInterface;
use App\EMS\Department\Repositories\DepartmentRepository;
use App\EMS\Department\Repositories\DepartmentRepositoryInterface;
use App\EMS\Designation\Repositories\DesignationRepository;
use App\EMS\Designation\Repositories\DesignationRepositoryInterface;
use App\EMS\Holiday\Repositories\HolidayRepository;
use App\EMS\Holiday\Repositories\HolidayRepositoryInterface;
use App\EMS\Leave\Repositories\LeaveRepository;
use App\EMS\Leave\Repositories\LeaveRepositoryInterface;
use App\EMS\LeaveType\Repositories\LeaveTypeRepository;
use App\EMS\LeaveType\Repositories\LeaveTypeRepositoryInterface;
use App\EMS\Message\Repositories\MessageRepository;
use App\EMS\Message\Repositories\MessageRepositoryInterface;
use App\EMS\Notification\Repositories\NotificationRepository;
use App\EMS\Notification\Repositories\NotificationRepositoryInterface;
use App\EMS\Permission\Repositories\PermissionRepository;
use App\EMS\Permission\Repositories\PermissionRepositoryInterface;
use App\EMS\Role\Repositories\RoleRepository;
use App\EMS\Role\Repositories\RoleRepositoryInterface;
use App\EMS\State\Repositories\StateRepository;
use App\EMS\State\Repositories\StateRepositoryInterface;
use App\EMS\Todo\Repositories\TodoRepository;
use App\EMS\Todo\Repositories\TodoRepositoryInterface;
use App\EMS\User\Repositories\UserRepository;
use App\EMS\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(DesignationRepositoryInterface::class, DesignationRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
        $this->app->bind(LeaveTypeRepositoryInterface::class, LeaveTypeRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, LeaveRepository::class);
        $this->app->bind(ComplaintRepositoryInterface::class, ComplaintRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
    }
}
