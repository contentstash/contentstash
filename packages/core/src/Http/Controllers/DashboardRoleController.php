<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardRoleController extends Controller
{
    /**
     * Validates the request data for creating or updating a role.
     */
    private function validateRoleRequest(): array
    {
        return Request::validate([
            'name' => 'required|string',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);
    }

    /**
     * Shows a list of all roles.
     */
    public function index(): Response
    {
        $roles = Role::all();

        return Inertia::render('Dashboard/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Shows the role builder for a new role.
     */
    public function create(): Response
    {
        return Inertia::render('Dashboard/Roles/Create');
    }

    /**
     * Stores a new role.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = Role::create($this->validateRoleRequest());

        return redirect()->route('dashboard.roles.edit', $role);
    }

    /**
     * Shows the role builder for an existing role.
     */
    public function edit(Role $role): Response
    {
        return Inertia::render('Dashboard/Roles/[id]/Edit', [
            'role' => $role,
        ]);
    }

    /**
     * Updates an existing role.
     */
    public function update(Role $role): RedirectResponse
    {
        $role->update($this->validateRoleRequest());

        return redirect()->route('dashboard.roles.edit', $role);
    }

    /**
     * Deletes a role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('dashboard.roles.index');
    }
}
