<?php

namespace App\Services;

use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;

class OrganizationService
{
    /**
     * Create a new organization.
     *
     * @param User $user
     * @return Organization
     */
    public function createOrganization(User $user): Organization
    {
        // Assuming you have an Organization model and a User model with proper relationships

        $organization = new Organization();
        $organization->name = 'New Organization'; // Set the organization name as per your requirements
        $organization->trial_ends_at = Carbon::now()->addDays(30);
        $organization->save();

        // Attach the user to the organization
        $organization->users()->attach($user, ['role' => 'admin']);

        // Trigger email confirmation to the user
        $this->sendEmailConfirmation($user, $organization);

        return $organization;
    }

    /**
     * Get a collection of organizations based on the filter.
     *
     * @param User $user
     * @param string $filter
     * @return \Illuminate\Database\Eloquent\Collection|Organization[]
     */
    public function getOrganizations(User $user, string $filter = 'all')
    {
        // Implement the logic to fetch organizations based on the filter
        // Assuming you have a relationship between User and Organization models

        $query = $user->organizations();

        switch ($filter) {
            case 'subbed':
                $query->where('subscribed', true);
                break;
            case 'trial':
                $query->where('trial_ends_at', '>=', Carbon::now());
                break;
            default:
                // Fetch all organizations
                break;
        }

        return $query->get();
    }

    /**
     * Send email confirmation to the user upon organization creation.
     *
     * @param User $user
     * @param Organization $organization
     */
    private function sendEmailConfirmation(User $user, Organization $organization)
    {
        // Implement the logic to send the email confirmation to the user
        // You can use Laravel's built-in Mail feature or any email package of your choice
    }
}
