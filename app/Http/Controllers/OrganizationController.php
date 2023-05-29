<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganizationRequest;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Create a new organization.
     *
     * @param CreateOrganizationRequest $request
     * @return JsonResponse
     */
    public function create(CreateOrganizationRequest $request): JsonResponse
    {
        $user = Auth::user();
        $organization = $this->organizationService->createOrganization($user);

        return fractal()
            ->item($organization)
            ->transformWith(new UserTransformer()) // Use the UserTransformer to include relevant user data
            ->toArray();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            // Add validation rules for the request data
        ]);

        $user = auth()->user();
        $organisation = $this->organisationService->createOrganisation($request->all(), $user);

        // Trigger email sending logic here

        $transformer = new UserTransformer(); // Create your UserTransformer class
        $data = $transformer->transform($user);

        return response()->json([
            'organisation' => $organisation,
            'user' => $data,
        ]);
    }


    /**
     * Get a collection of organizations based on the filter.
     *
     * @param string $filter
     * @return JsonResponse
     */
    public function index(string $filter = 'all'): JsonResponse
    {
        $user = Auth::user();
        $organizations = $this->organizationService->getOrganizations($user, $filter);

       return fractal()
        ->collection($organizations)
        ->transformWith(new OrganizationTransformer())
        ->includeUser()
        ->toArray();
    }
}
