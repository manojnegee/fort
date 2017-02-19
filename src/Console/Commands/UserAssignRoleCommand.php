<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Console\Commands;

use Rinvex\Fort\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;

class UserAssignRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fort:user:assignrole
                            {user? : The user identifier}
                            {role? : The role identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userField = $this->argument('user') ?: $this->ask(Lang::get('rinvex.fort::artisan.user.identifier'));

        if (intval($userField)) {
            $user = User::find($userField);
        } elseif (filter_var($userField, FILTER_VALIDATE_EMAIL)) {
            $user = User::where(['email' => $userField])->first();
        } else {
            $user = User::where(['username' => $userField])->first();
        }

        if (! $user) {
            return $this->error(Lang::get('rinvex.fort::artisan.user.invalid', ['field' => $userField]));
        }

        $roleField = $this->argument('role') ?: $this->anticipate(Lang::get('rinvex.fort::artisan.user.role'), Role::all()->pluck('slug', 'id')->toArray());

        if (intval($roleField)) {
            $role = Role::find($roleField);
        } else {
            $role = Role::where(['slug' => $roleField])->first();
        }

        if (! $role) {
            return $this->error(Lang::get('rinvex.fort::artisan.role.invalid', ['field' => $roleField]));
        }

        // Assign role to user
        $user->assignRole($role);

        $this->info(Lang::get('rinvex.fort::artisan.user.roleassigned', ['user' => $user->id, 'role' => $role->id]));
    }
}
